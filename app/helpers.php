<?php
/**
 * Global helpers file with misc functions.
 */
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('access');
    }
}
if (!function_exists('data_merge')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function data_merge($vglinkProducts, $rakutenProducts)
    {
        $data = [];
        $totalRecords = 0;
        if (arrayMerge($vglinkProducts, $rakutenProducts))
        {//产品数据merge
            $data['products'] = array_merge($vglinkProducts['products'], $rakutenProducts['products']);

            if (isset($rakutenProducts['pageInfo']))
            {
                $data['pageInfo'] = $rakutenProducts['pageInfo'];
            } elseif (isset($vglinkProducts['pageInfo'])) {
                $data['pageInfo'] = $vglinkProducts['pageInfo'];
            }
            $data['pageInfo']['totalRecords'] = count($data['products']);
        } elseif (is_array($rakutenProducts)) {
            $data = $rakutenProducts;
        } elseif (is_array($vglinkProducts)) {
            $data = $vglinkProducts;
        }

    /*    "pageNumber": 2,
            "pageSize": 20,
            "totalPage": 1488,
            "totalRecords": 29779

*/

        return $data;

    }
}
if (!function_exists('arrayMerge')) {

    function arrayMerge($vglinkProducts, $rakutenProducts)
    {
        if (
            is_array($rakutenProducts) &&
            is_array($vglinkProducts) &&
            $rakutenProducts &&
            $vglinkProducts &&
            isset($vglinkProducts['products']) &&
            isset($rakutenProducts['products'])
        ) {

            return true;
        }

        return false;

    }


}


if (!function_exists('history')) {
    /**
     * Access the history facade anywhere.
     */
    function history()
    {
        return app('history');
    }
}

if (!function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('includeRouteFiles')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);

            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('getRtlCss')) {

    /**
     * The path being passed is generated by Laravel Mix manifest file
     * The webpack plugin takes the css filenames and appends rtl before the .css extension
     * So we take the original and place that in and send back the path.
     *
     * @param $path
     *
     * @return string
     */
    function getRtlCss($path)
    {
        $path = explode('/', $path);
        $filename = end($path);
        array_pop($path);
        $filename = rtrim($filename, '.css');

        return implode('/', $path) . '/' . $filename . '.rtl.css';
    }
}

if (!function_exists('homeRoute')) {

    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (access()->allow('view-backend')) {
            return 'admin.dashboard';
        } elseif (auth()->check()) {
            return 'frontend.user.dashboard';
        }

        return 'frontend.index';
    }
}
