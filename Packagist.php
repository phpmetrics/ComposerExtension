<?php
namespace ComposerExtension;

class Packagist {

    public function get($package)
    {
        $response = new \StdClass;
        if(!preg_match('/\w+\/\w+/', $package)) {
            return $response;
        }
        list($user, $name) = explode('/', $package);
        $uri = sprintf('https://packagist.org/packages/%s/%s.json', $user, $name);
        $json = json_decode(file_get_contents($uri));

        // get latest version
        $latest = '0.0.0';
        foreach((array) $json->package->versions as $version => $datas) {
            $version = preg_replace('([^\.\d])', '', $version);
            if(!preg_match('!\d+\.\d+\.\d+!', $version)) {
                continue;
            }
            if (version_compare($version, $latest) == 1) {
                $latest = $version;
                $response->name = $package;
                $response->latest = $version;
                $response->license = $datas->license;
                $response->homepage = $datas->homepage;
                $response->time = $datas->time;
                $response->zip = $datas->dist->url;
            }
        }
        return $response;
    }

}