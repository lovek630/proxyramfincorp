<?php

class RateLimiter
{
    public function limit()
    {
        $ip = $this->get_ip();
        $limit = 5;     // max requests
        $window = 1.0;  // seconds (float)

        $file = sys_get_temp_dir() . "/rate_" . md5($ip);

        $current_time = microtime(true);

        $requests = [];

        $fp = fopen($file, 'c+');

        if ($fp === false) {
            return; // fail silently
        }

        flock($fp, LOCK_EX);

        $content = stream_get_contents($fp);
        if ($content) {
            $requests = json_decode($content, true) ?? [];
        }

        $requests = array_filter($requests, function ($timestamp) use ($current_time, $window) {
            return ($timestamp > ($current_time - $window));
        });

        if (count($requests) >= $limit) {
            flock($fp, LOCK_UN);
            fclose($fp);

            header('Content-Type: application/json');
            header('HTTP/1.1 429 Too Many Requests');

            echo json_encode([
                "status" => 0,
                "message" => "Too many requests. Try again later."
            ]);
            exit;
        }

        $requests[] = $current_time;

        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode(array_values($requests)));

        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    private function get_ip()
    {
	$remote_address = "";
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $remote_address = trim($_SERVER['HTTP_CF_CONNECTING_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            $remote_address = trim($ips[0]);
        } else {
            $remote_address = $_SERVER['REMOTE_ADDR'] ?? '';
        }
        return $remote_address;
    }
}