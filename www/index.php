<?php

$httpHost = $_SERVER['HTTP_HOST'];

# validate HTTP_HOST
if (filter_var($httpHost, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) == false) {
  http_response_code(404);
  exit("bad HTTP_HOST Header");
}

$domain = '_redirect.' . $httpHost;
$dnsQuery = dns_get_record($domain, $type = DNS_TXT);
$redirectTo = $dnsQuery[0]['txt'];

# We use a temporary '302 found' redirect so the browser doesn't cache it.
# This is easier in case the redirect should be changed later.
header("Location: $redirectTo", true, 302);
