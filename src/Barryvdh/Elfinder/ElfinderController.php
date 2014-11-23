<?php
namespace Barryvdh\Elfinder;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class ElfinderController extends \Controller
{
    protected $package = 'laravel-elfinder';

    public function showIndex()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::elfinder')->with(compact('dir', 'locale'));
    }

    public function showTinyMCE()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::tinymce')->with(compact('dir', 'locale'));
    }

    public function showTinyMCE4()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        $csrf = Config::get($this->package . '::csrf');
        
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::tinymce4')->with(compact('dir', 'locale','csrf'));
    }

    public function showCKeditor4()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::ckeditor4')->with(compact('dir', 'locale'));
    }

    public function showConnector()
    {
        $dir = Config::get($this->package . '::dir');
        $roots = Config::get($this->package . '::roots');

        if (!$roots)
        {
            $roots = array(
                array(
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => public_path() . DIRECTORY_SEPARATOR . $dir, // path to files (REQUIRED)
                    'URL' => asset($dir), // URL to files (REQUIRED)
                    'accessControl' => Config::get($this->package . '::access') // filter callback (OPTIONAL)
                )
            );
        }

        $opts = Config::get($this->package . '::options', array());
        $opts = array_merge(array(
            'roots' => $roots
        ), $opts);

        // run elFinder
        $connector = new \elFinderConnector(new \elFinder($opts));
        return Response::stream(function () use($connector) {
                $connector->run();
            });
    }

    public function showPopup($input_id)
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = \Config::get('app.locale');
        if ( ! file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }

        return \View::make($this->package . '::standalonepopup')->with(compact('dir', 'locale', 'input_id'));
    }
}
