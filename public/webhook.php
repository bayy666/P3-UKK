<?php

class WebhookDeployer {
    private $secret = 'aku-suka-rama-rudi';
    private $projectDir = '/var/www/laravel-app';
    private $logFile = '/var/log/webhook-deploy.log';
    
    public function handle() {
        try {
            $this->log('🔔 Webhook received');
            
            // Security check
            if (!$this->verifySignature()) {
                $this->log('❌ Signature verification failed');
                $this->respond(403, 'Forbidden');
                return;
            }
            
            if (!$this->isMainBranch()) {
                $this->log('ℹ️ Not main branch, skipping');
                $this->respond(200, 'OK - Not main branch');
                return;
            }
            
            // Execute deployment
            $this->deploy();
            
        } catch (Exception $e) {
            $this->log('💥 Error: ' . $e->getMessage());
            $this->respond(500, 'Deployment failed');
        }
    }
    
    private function verifySignature() {
        $headers = getallheaders();
        $payload = file_get_contents('php://input');
        
        if (!isset($headers['X-Hub-Signature-256'])) {
            return false;
        }
        
        $signature = 'sha256=' . hash_hmac('sha256', $payload, $this->secret);
        return hash_equals($signature, $headers['X-Hub-Signature-256']);
    }
    
    private function isMainBranch() {
        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);
        return isset($data['ref']) && $data['ref'] === 'refs/heads/main';
    }
    
    private function deploy() {
        $this->log('🚀 Starting deployment');
        
        chdir($this->projectDir);
        
        // Execute deploy script
        $output = shell_exec('php deploy.php 2>&1');
        
        $this->log("✅ Deployment completed\n" . $output);
        $this->respond(200, 'Deployment successful');
    }
    
    private function log($message) {
        file_put_contents($this->logFile, date('[Y-m-d H:i:s] ') . $message . "\n", FILE_APPEND);
    }
    
    private function respond($code, $message) {
        http_response_code($code);
        echo $message;
    }
}

// Run the webhook
$deployer = new WebhookDeployer();
$deployer->handle();

?>