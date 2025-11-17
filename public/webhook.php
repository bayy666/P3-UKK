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
        
        // Execute deploy commands dengan sudo untuk permission
        $commands = [
            'sudo -u www-data git pull origin main',
            'sudo -u www-data composer install --no-dev --optimize-autoloader',
            'sudo -u www-data php artisan migrate --force',
            'sudo -u www-data php artisan config:cache',
            'sudo -u www-data php artisan route:cache', 
            'sudo -u www-data php artisan view:cache',
            'sudo chmod -R 775 storage bootstrap/cache',
            'sudo chown -R www-data:www-data .'
        ];
        
        $output = "";
        foreach ($commands as $cmd) {
            $this->log("Executing: $cmd");
            $result = shell_exec("$cmd 2>&1");
            $output .= "=== $cmd ===\n$result\n";
        }
        
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