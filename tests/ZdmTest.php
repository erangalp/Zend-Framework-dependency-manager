<?php
class ZdmTest extends PHPUnit_Framework_TestCase {
	public function getTmpdir() {
		return dirname(__FILE__) . '/tmp';
	}
	public function setUp() {
		$tmpFolder = $this ->getTmpdir();
		if(!is_dir($tmpFolder)) {
			mkdir($tmpFolder,0755);
		}
		Zdm::start(array(
			'libraryPath' => $tmpFolder,
			'zfVersion' => '',
			'repository' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'zdmfiles'
		));
	}

	public function tearDown() {
		$path = $this ->getTmpdir();
		$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

		for ($dir->rewind(); $dir->valid(); $dir->next()) {
			if ($dir->isDir()) {
				rmdir($dir->getPathname());
			} else {
				unlink($dir->getPathname());
			}
		}
		rmdir($path);
	}
	
	public function testFetch() {
		$file = 'Zend/Version.php';
		Zdm::getInstance() ->fetch($file);
		$file = $this ->getTmpdir() . '/' . $file;
		$this -> assertTrue(is_file($file));
	}

	public function testFetchDir() {
		$dir = 'Zend/Uri';
		Zdm::getInstance() ->fetchDir($dir);
		$path = $this ->getTmpdir() . '/' . $dir;
		$this -> assertTrue(is_dir($path));
		$this -> assertEquals(count(glob($path . '/*.*')),2);
	}
	public function testfetchWithDependencies() {
		$file = 'Zend/Controller/Action.php';
		Zdm::getInstance() -> fetch($file);
		$file = $this ->getTmpdir() . '/' . $file;
		$this -> assertTrue(is_file($file));
		$dir = $this ->getTmpdir() . '/Zend/Controller/Action/Helper';
		$this -> assertTrue(is_dir($dir));
		$this -> assertEquals(count(glob($dir . '/*.*')),1);
	}
}