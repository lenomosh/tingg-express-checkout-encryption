
<?php
require_once __DIR__ . '/vendor/autoload.php';
use checkout\encryption\Encryption;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Alternatively configure this on your web server(apache/nginx) to avoid CORS error
header("Access-Control-Allow-Origin: *");

class CheckoutEncryption {

    private $accessKey;
    private $ivKey;
    private $secretKey;
    private $request;

    public function __construct() {
        $this->accessKey = $_ENV['ACCESS_KEY'];
        $this->ivKey = $_ENV['IV_KEY'];
        $this->secretKey = $_ENV['SECRET_KEY'];
        $this->serviceCode = $_ENV['SERVICE_CODE'];
        $this->callbackURL = $_ENV['CALLBACK_URL'];
        $this->successUrl = $_ENV['SUCCESS_URL'];
        $this->pendingURL = $_ENV['PENDING_URL'];
        $this->failedUrl = $_ENV['FAILED_URL'];

        $jsonObject = json_decode(file_get_contents('php://input'), true);

        $minutes_to_add = 30;

	    $this->request = array_merge($jsonObject,[
            'service_code'=>$this->serviceCode,
            'access_key'=>$this->serviceCode,
            'iv_key'=>$this->serviceCode,
            'secret_key'=>$this->serviceCode,
            'callback_url'=>$this->callbackURL,
            'pending_redirect_url'=>$this->pendingURL,
            'success_redirect_url'=>$this->successUrl,
            'fail_redirect_url'=>$this->failedUrl,
            'due_date'=>(new DateTime())->modify('+'. $minutes_to_add . ' minutes')->format('Y-m-d H:i:s')
        ]);;

    }

    public function processEncryption() {
        $obj = new Encryption();
        $encryptedParams = $obj->encrypt($this->ivKey, $this->secretKey, $this->request);
				return $encryptedParams;
    }

    public function getURL(){
        $url = "https://online.uat.tingg.africa/testing/express/checkout";
        $payload = $this->processEncryption();

        return $url ."?" . http_build_query([
            'encrypted_payload'=>$payload,
            'access_key' =>$this->accessKey
        ]);

    }

}

$class = new CheckoutEncryption();

header('Content-type: appplication/json');
echo json_encode(['data'=>$class->getURL()]);

?>