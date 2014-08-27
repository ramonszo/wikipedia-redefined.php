<?php

/**
 * Simple Cache
 * 
 * @author Thiago Belem <contato@thiagobelem.net>
 * @link http://blog.thiagobelem.net/
 */
class WikiCache {
	private static $time = '5 minutes';
	private $folder;

	/**
	 * Constructor
	 * 
	 * Init the class and define where the temporary files will be saved.
	 * If you leave the parameter $folder empty, the temporary files will be saved on your SO tmp files.
	 * 
	 * @uses Cache::setFolder() Define the folder to save cache files
	 * 
	 * @param string $folder Directory to save the cache files (optional)
	 * 
	 * @return void
	 */
	public function __construct($folder = null) {
		$this->setFolder(!is_null($folder) ? $folder : sys_get_temp_dir());
	}
	
	/**
	 * Define where the files will be saved.
	 * 
	 * Will check if the folder is writeable. If not, a error message will be displayed.
	 * 
	 * @param string $folder Directory to save the cache files (optional)
	 * 
	 * @return void
	 */
	public function setFolder($folder) {
		if (file_exists($folder) && is_dir($folder) && is_writable($folder)) {
			$this->folder = $folder;
		} else {
			trigger_error("Can't access the cache folder", E_USER_ERROR);
		}
	}
	
	/**
	 * Generate the cache filename
	 * 
	 * @param string $key A key to identify the file
	 * 
	 * @return string Cache folder + filename
	 */
	protected function generateFileLocation($key) {
		return $this->folder . DIRECTORY_SEPARATOR . sha1($key) . '.tmp';
	}
	
	/**
	 * Create a cache file
	 * 
	 * @uses Cache::generateFileLocation() to generate the cache file location
	 * 
	 * @param string $key A key to identify the file
	 * @param string $content Cache content
	 * 
	 * @return boolean If the file was created
	 */
	protected function createCacheFile($key, $content) {
		// Generate the filename
		$filename = $this->generateFileLocation($key);
		
		// Create the file with the contents
		return file_put_contents($filename, $content)
			OR trigger_error("Can't create the cache file", E_USER_ERROR);
	}
	
	/**
	 * Save a value on cache
	 * 
	 * @uses Cache::createCacheFile() to create the cache file
	 * 
	 * @param string $key A key to identify the file
	 * @param mixed $content Content to be cached
	 * @param string $time The cache will be expired on... (optional)
	 * 
	 * @return boolean If the file was created
	 */
	public function save($key, $content, $time = null) {
		$time = strtotime(!is_null($time) ? $time : self::$time);
			
		$content = serialize(array(
			'expires' => $time,
			'content' => $content));
		
		return $this->createCacheFile($key, $content);
	}
	
	
	/**
	 * Save the cache content
	 * 
	 * @uses Cache::generateFileLocation() to generate the filename
	 * 
	 * @param string $key A key to identify the file
	 * 
	 * @return mixed If the cache was found returns its value, otherwise returns NULL
	 */
	public function read($key) {
		$filename = $this->generateFileLocation($key);
		if (file_exists($filename) && is_readable($filename)) {
			$cache = unserialize(file_get_contents($filename));
			if ($cache['expires'] > time()) {
				return $cache['content'];
			} else {
				unlink($filename);
			}
		}
		return null;
	}
}

?>