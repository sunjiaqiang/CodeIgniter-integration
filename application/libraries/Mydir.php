<?php
/**
 * 文件目录操作类
 *
 * 例子：
 * $fileutil = new fileDirUtil();
 * $fileutil->createDir('a/1/2/3');                 测试建立文件夹  建一个a/1/2/3文件夹
 * $fileutil->createFile('b/1/2/3');                测试建立文件    在b/1/2/文件夹下面建一个3文件
 * $fileutil->createFile('b/1/2/3.txt');            测试建立文件    在b/1/2/文件夹下面建一个3.exe文件
 * $fileutil->writeFile('b/1/2/3.txt','this is something i write!');    在文件中写内容
 * $arr = $fileutil->readFile2array('example/mysql.txt');
 * $arr = $fileutil->readsFile('example/mysql.txt');
 * $size=$fileutil->getRealSize($fileutil->getDirSize("example"));      得到文件或目录的大小
 * $fileutil->copyDir('b','d/e');                   测试复制文件夹  建立一个d/e文件夹，把b文件夹下的内容复制进去
 * $fileutil->copyFile('b/1/2/3.exe','b/b/3.exe');  测试复制文件    建立一个b/b文件夹，并把b/1/2文件夹中的3.exe文件复制进去
 * $fileutil->moveDir('a/','b/c');                  测试移动文件夹  建立一个b/c文件夹,并把a文件夹下的内容移动进去，并删除a文件夹
 * $fileutil->moveFile('b/1/2/3.exe','b/d/3.exe');  测试移动文件    建立一个b/d文件夹，并把b/1/2中的3.exe移动进去          
 * $fileutil->unlinkFile('b/d/3.exe');              测试删除文件    删除b/d/3.exe文件
 * $fileutil->unlinkDir('d');                       测试删除文件夹  删除d文件夹	
 * $list = $fileutil->dirList("E:\example");        测试列表文件夹  列出目录下所有文件
 * $list = $fileutil->dirTree("/");                 测试列表文件夹树  列出目录下所有文件直接直接的树关系
 */
class Mydir{
	/**
	 * 建立文件夹
	 *
	 * @param  string $aimUrl
	 * @return  viod
	 */
	function createDir($aimUrl, $mode = 0777) {
		$aimUrl = str_replace ( '', '/', $aimUrl );
		$aimDir = '';
		$arr = explode ( '/', $aimUrl );
		foreach ( $arr as $str ) {
			$aimDir .= $str . '/';
			if (! file_exists ( $aimDir )) {
				mkdir ( $aimDir, $mode );
			}
		}
	}
	/**
	 * 建立文件
	 *
	 * @param  string  $aimUrl
	 * @param  boolean  $overWrite 该参数控制是否覆盖原文件
	 * @return  boolean
	 */
	function createFile($aimUrl, $overWrite = false) {
		if (file_exists ( $aimUrl ) && $overWrite == false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true) {
			$this->unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		$this->createDir ( $aimDir );
		touch ( $aimUrl );
		return true;
	}
	/**
	 * 移动文件夹
	 *
	 * @param  string  $oldDir
	 * @param  string  $aimDir
	 * @param  boolean  $overWrite 该参数控制是否覆盖原文件
	 * @return  boolean
	 */
	function moveDir($oldDir, $aimDir, $overWrite = false) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir )) {
			return false;
		}
		if (! file_exists ( $aimDir )) {
			$this->createDir ( $aimDir );
		}
		@$dirHandle = opendir ( $oldDir );
		if (! $dirHandle) {
			return false;
		}
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $oldDir . $file )) {
				$this->moveFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else {
				$this->moveDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $oldDir );
	}
	/**
	 * 移动文件
	 *
	 * @param  string  $fileUrl
	 * @param  string  $aimUrl
	 * @param  boolean  $overWrite 该参数控制是否覆盖原文件
	 * @return  boolean
	 */
	function moveFile($fileUrl, $aimUrl, $overWrite = false) {
		if (! file_exists ( $fileUrl )) {
			return false;
		}
		if (file_exists ( $aimUrl ) && $overWrite = false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite = true) {
			$this->unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		$this->createDir ( $aimDir );
		rename ( $fileUrl, $aimUrl );
		return true;
	}
	/**
	 * 删除文件夹
	 *
	 * @param  string  $aimDir
	 * @return  boolean
	 */
	function unlinkDir($aimDir) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		if (! is_dir ( $aimDir )) {
			return false;
		}
		$dirHandle = opendir ( $aimDir );
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $aimDir . $file )) {
				$this->unlinkFile ( $aimDir . $file );
			} else {
				$this->unlinkDir ( $aimDir . $file );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $aimDir );
	}
	/**
	 * 删除文件
	 *
	 * @param  string  $aimUrl
	 * @return  boolean
	 */
	function unlinkFile($aimUrl) {
		if (file_exists ( $aimUrl )) {
			unlink ( $aimUrl );
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 复制文件夹
	 *
	 * @param  string  $oldDir
	 * @param  string  $aimDir
	 * @param  boolean  $overWrite 该参数控制是否覆盖原文件
	 * @return  boolean
	 */
	function copyDir($oldDir, $aimDir, $overWrite = false) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir )) {
			return false;
		}
		if (! file_exists ( $aimDir )) {
			$this->createDir ( $aimDir );
		}
		$dirHandle = opendir ( $oldDir );
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $oldDir . $file )) {
				$this->copyFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else {
				$this->copyDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		return closedir ( $dirHandle );
	}
	/**
	 * 复制文件
	 *
	 * @param  string  $fileUrl
	 * @param  string  $aimUrl
	 * @param  boolean  $overWrite 该参数控制是否覆盖原文件
	 * @return  boolean
	 */
	function copyFile($fileUrl, $aimUrl, $overWrite = false) {
		if (! file_exists ( $fileUrl )) {
			return false;
		}
		if (file_exists ( $aimUrl ) && $overWrite == false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true) {
			$this->unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		$this->createDir ( $aimDir );
		copy ( $fileUrl, $aimUrl );
		return true;
	}
	/**
	 * 将字符串写入文件
	 *
	 * @param  string  $filename 文件名
	 * @param  boolean $str 待写入的字符数据
	 */
	function writeFile($filename, $str) {
		if (function_exists ('file_put_contents')) {
			file_put_contents ( $filename, $str );
		} else {
			$fp = fopen ( $filename, "wb" );
			fwrite ( $fp, $str );
			fclose ( $fp );
		}
	}
	/**
	 * 将整个文件内容读出到一个字符串中
	 *
	 * @param  string  $filename 文件名
	 * @return array
	 */
	function readsFile($filename) {
		if (function_exists ( file_get_contents )) {
			return file_get_contents ( $filename );
		} else {
			$fp = fopen ( $filename, "rb" );
			$str = fread ( $fp, filesize ( $filename ) );
			fclose ( $fp );
			return $str;
		}
	}
	/**
	 * 将文件内容读出到一个数组中
	 *
	 * @param  string  $filename 文件名
	 * @return array
	 */
	function readFile2array($filename) {
		$file = file ( $filename );
		$arr = array ();
		foreach ( $file as $value ) {
			$arr [] = trim ( $value );
		}
		return $arr;
	}
	/**
	 * 转化 \ 为 /
	 *
	 * @param	string	$path	路径
	 * @return	string	路径
	 */
	function dirPath($path) {
		$path = str_replace ( '\\', '/', $path );
		if (substr ( $path, - 1 ) != '/')
			$path = $path . '/';
		return $path;
	}
	/**
	 * 转换目录下面的所有文件编码格式
	 *
	 * @param	string	$in_charset		原字符集
	 * @param	string	$out_charset	目标字符集
	 * @param	string	$dir			目录地址
	 * @param	string	$fileexts		转换的文件格式
	 * @return	string	如果原字符集和目标字符集相同则返回false，否则为true
	 */
	function dirIconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
		if ($in_charset == $out_charset)
			return false;
		$list = $this->dirList ( $dir );
		foreach ( $list as $v ) {
			if (preg_match ( "/\.($fileexts)/i", $v ) && is_file ( $v )) {
				file_put_contents ( $v, iconv ( $in_charset, $out_charset, file_get_contents ( $v ) ) );
			}
		}
		return true;
	}
	/**
	 * 列出目录下所有文件
	 *
	 * @param	string	$path		路径
	 * @param	string	$exts		扩展名
	 * @param	array	$list		增加的文件列表
	 * @return	array	所有满足条件的文件
	 */
	function dirList($path, $exts = '', $list = array()) {
		$path = $this->dirPath ( $path );
		$files = glob ( $path . '*' );
		foreach ( $files as $v ) {
			$fileext = $this->getSuffix ( $v );
			if (! $exts || preg_match ( "/\.($exts)/i", $v )) {
				$list [] = $v;
				if (is_dir ( $v )) {
					$list = $this->dirList ( $v, $exts, $list );
				}
			}
		}
		return $list;
	}
	/**
	 * 设置目录下面的所有文件的访问和修改时间
	 *
	 * @param	string	$path		路径
	 * @param	int		$mtime		修改时间
	 * @param	int		$atime		访问时间
	 * @return	array	不是目录时返回false，否则返回 true
	 */
	function dirTouch($path, $mtime = TIME, $atime = TIME) {
		if (! is_dir ( $path ))
			return false;
		$path = $this->dirPath ( $path );
		if (! is_dir ( $path ))
			touch ( $path, $mtime, $atime );
		$files = glob ( $path . '*' );
		foreach ( $files as $v ) {
			is_dir ( $v ) ? $this->dirTouch ( $v, $mtime, $atime ) : touch ( $v, $mtime, $atime );
		}
		return true;
	}
	/**
	 * 目录列表
	 *
	 * @param	string	$dir		路径
	 * @param	int		$parentid	父id
	 * @param	array	$dirs		传入的目录
	 * @return	array	返回目录及子目录列表
	 */
	function dirTree($dir, $parentid = 0, $dirs = array()) {
		global $id;
		if ($parentid == 0)
			$id = 0;
		$list = glob ( $dir . '*' );
		foreach ( $list as $v ) {
			if (is_dir ( $v )) {
				$id ++;
				$dirs [$id] = array ('id' => $id, 'parentid' => $parentid, 'name' => basename ( $v ), 'dir' => $v . '/' );
				$dirs = $this->dirTree ( $v . '/', $id, $dirs );
			}
		}
		return $dirs;
	}
	/**
	 * 目录列表
	 *
	 * @param	string	$dir		路径
	 * @return	array	返回目录列表
	 */
	function dirNodeTree($dir) {
		$d = dir ( $dir );
		$dirs = array();
		while ( false !== ($entry = $d->read ()) ) {
			if ($entry != '.' and $entry != '..' and is_dir ( $dir . '/' . $entry )) {
				$dirs[] = $entry;
			}
		}
		return $dirs;
	}
	/**
	 * 获取目录大小
	 *
	 * @param	string	$dirname	目录
	 * @return	string	  比特B
	 */
	function getDirSize($dirname) {
		if (! file_exists ( $dirname ) or ! is_dir ( $dirname ))
			return false;
		if (! $handle = opendir ( $dirname ))
			return false;
		$size = 0;
		while ( false !== ($file = readdir ( $handle )) ) {
			if ($file == "." or $file == "..")
				continue;
			$file = $dirname . "/" . $file;
			if (is_dir ( $file )) {
				$size += $this->getDirSize ( $file );
			} else {
				$size += filesize ( $file );
			}
		
		}
		closedir ( $handle );
		return $size;
	}
	/**
	 * 单位自动转换函数
	 *
	 * @param	string	$size
	 * @return	string	  
	 */
	function getRealSize($size) {
		$kb = 1024;
		$mb = $kb * 1024;
		$gb = $mb * 1024;
		$tb = $gb * 1024;
		if ($size < $kb)
			return $size . "B";
		if ($size >= $kb and $size < $mb)
			return round ( $size / $kb, 2 ) . "KB";
		if ($size >= $mb and $size < $gb)
			return round ( $size / $mb, 2 ) . "MB";
		if ($size >= $gb and $size < $tb)
			return round ( $size / $gb, 2 ) . "GB";
		if ($size >= $tb)
			return round ( $size / $tb, 2 ) . "TB";
	}
	/**
	 * 获取文件名后缀
	 *
	 * @param	string	$filename
	 * @return	string	  
	 */
	function getSuffix($filename) {
		if (file_exists ( $filename ) and is_file ( $filename )) {
			return end ( explode ( ".", $filename ) );
		}
	}
}
?>