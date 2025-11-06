<?php
$base = 'http://127.0.0.1:8001';
$cookie = sys_get_temp_dir() . '/laravel_e2e_cookie.txt';

function http_request($url, $method = 'GET', $data = null, $cookie = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    }
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }
    $resp = curl_exec($ch);
    if ($resp === false) {
        $err = curl_error($ch);
        curl_close($ch);
        throw new Exception('CURL error: ' . $err);
    }
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $code, 'body' => $resp];
}

try {
    echo "GET /login to obtain CSRF token...\n";
    $r = http_request($base . '/login', 'GET', null, $cookie);
    echo "HTTP " . $r['code'] . "\n";
    if (preg_match('/name="_token" value="([^"]+)"/', $r['body'], $m)) {
        $token = $m[1];
        echo "Found CSRF token: $token\n";
    } else {
        echo "No CSRF token found in login page.\n";
        exit(1);
    }

    echo "POST /login with seeded user...\n";
    $post = ['_token' => $token, 'email' => 'test@example.com', 'password' => 'password'];
    $r2 = http_request($base . '/login', 'POST', $post, $cookie);
    echo "After login POST HTTP " . $r2['code'] . "\n";

    echo "GET /dashboard...\n";
    $r3 = http_request($base . '/dashboard', 'GET', null, $cookie);
    echo "Dashboard HTTP " . $r3['code'] . "\n";
    $snippet = substr($r3['body'], 0, 800);
    echo "--- Dashboard HTML snippet ---\n";
    echo $snippet . "\n";
    echo "--- end snippet ---\n";
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
