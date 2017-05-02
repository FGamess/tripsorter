<?php

namespace Api\V1;

/**
 * Api Class to handle initial forwarding
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
abstract class ApiBehavior
{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    
    /**
     * Property: file
     * Stores the input of the PUT request
     */
     protected $file = Null;
    
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    
    /**
     * Property : query
     * Contains $_GET. Basically an array
     * @var array
     */
    protected $query;
    
    /**
     * Property : postValues
     * Contains $_POST. Basically an array
     * @var array 
     */
    protected $postValues;
    
    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct($request)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
        
        $this->args = explode('/', rtrim($request, '/'));
        
        $this->endpoint = array_shift($this->args);
        
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) {
        case 'DELETE':
        case 'POST':
            $this->request = $this->cleanInputs($this->postValues);
            break;
        case 'GET':
            $this->request = $this->cleanInputs($this->query);
            break;
        case 'PUT':
            $this->request = $this->cleanInputs($this->query);
            $this->file = file_get_contents("php://input");
            break;
        default:
            $this->buildResponse('Invalid Method', 405);
            break;
        }
    }
    
    /**
     * Build response based on given data.
     * Base behavior : if you choose to use method name as endpoints, check if 
     * the method corresponding to the endpoint exist
     * @return type
     */
    public function processAPI() {
        if (method_exists($this, $this->endpoint)) {
            return $this->buildResponse($this->{$this->endpoint}($this->args));
        }
        return $this->buildResponse("No Endpoint: $this->endpoint", 404);
    }
    
    protected function buildResponse($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->getRequestStatus($status));
        return json_encode($data);
    }
    
    private function cleanInputs($data) {
        $cleanInput = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $cleanInput[$k] = $this->cleanInputs($v);
            }
        } else {
            $cleanInput = trim(strip_tags($data));
        }
        return $cleanInput;
    }

    private function getRequestStatus($code) {
        $status = array(  
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }
    
}
