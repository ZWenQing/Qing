<?php

class MyTpl{
	public $template_dir = "templates";
	public $compile_dir = "templates_c";
	public $left_delimiter =  "<{";
	public $right_delimiter = "}>";
	private $tpl_vars = array();
	/*
		将php中的分配值会保存到成员属性$tpl_vars中用于将板中相对应的变量进行替换
		@param string $tpl_vars 需要一个字符串参数作为关联下标，要和模板中的变量名对应
		@param string $value 需要一个标量类型的值，用来分配给模板中的变量的值
	*/

	function assign($tpl_var , $value= null){
		if($tpl_var != ""){
			$this->tpl_vars[$tpl_var] = $value ;
		}
	}
	/*
		加载指定目录的模板文件，并将替换后的内容生成组合文件存放到另一个指定目录下
		@param string $fileName  提供模板文件名
	*/
	function display($fileName){
		//var_dump(file_exists("home/".$this->template_dir."/index.html"));
		//die("jieshu");
		/*到指定的目录寻找模板文件*/
		$tplFile = $this->template_dir."/".$fileName;
		if(!file_exists($tplFile)){
			die("模板文件{$tplFile}不存在");
		}
		/*	获取组合的模板文件，该文件的内容都是被替换过的*/
		$comFileName = $this->compile_dir."/com_".$fileName.".php";
		/*判断替换后的文件是否存在厚实存在但有改动*/
		if( !file_exists($comFileName) || filemtime($comFileName) < filemtime($tplFile)){
			/*调用内部替换模板方法*/
			$repContent = $this->tpl_replace(file_get_contents($tplFile));
			/*保存由系统组合后的脚本文件*/
			file_put_contents($comFileName,$repContent);
		}
			/*包含处理后的模板文件输出给客户*/
			include($comFileName);
		
	}
	/*
		内部使用的私有方法，使用正则表达式将模板文件'<{}>'中的语句替换成对应的值或者php代码
		@param string $content 提供从模板文件读入的全部内容字符串
		@return $repContent    返回替换后的字符串
	*/
	private function tpl_replace($content){
		/*将左右定界符号中，有影响正则的特殊符号转义 例如，<{}>转义成\<\{\}\>*/
		$left = preg_quote($this->left_delimiter,"/");
		$right = preg_quote($this->right_delimiter,"/");
		/*匹配模板中各种表示符的正则表达式的模式数组*/
		$pattern = array(
			/*匹配模板中变量,例如，“<{ $valr }>”*/
			'/'.$left.'\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*'.$right.'/i',
			/*匹配模板中if标示符，例如"<{if $col=="sex"}><{/if}>"*/
			'/'.$left.'\s*else\s*if\s*(.+?)\s*'.$right.'(.+?)'.$left.'\s*\/if\s*'.$right.'/ies',
			/*匹配else标示符,例如"<{ else }>"*/
			'/'.$left.'\s*else\s*'.$right.'/is',
			/*用来匹配模板中的loop标示符，用来遍历数组中的值，例如"<{ loop $arrs $value }><{ /loop }>"*/
			'/'.$left.'\s*loop\s+\$(\s+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s'.$right.'(.+?)'.$left.'\s*\/loop\s*'.$right.'/is',
			/*用来遍历数组中的键和值，例如"<{ loop $arrs $key => $vaule }><{ \loop }>"*/
			'/'.$left.'\s*loop\s+\$(\s+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*=>\s*\$(\s+)\s*'.$right.'(.+?)'.$left.'\s*\/loop \s*'.$right.'/is',
			/*匹配include标示符，例如，"<{ include "header.html" }>"*/
			'/'.$left.'\s*include\s+[\"\']?(.+?)[\"\']?\s*'.$right.'/ie'
		);
		$replacement = array(
			/* 替换模板中的变量<?php echo $this->tpl_vars["var"] ?> */
			'<?php echo $this->tpl_vars["${1}"]; ?>',
			/*替换模板中的if字符串<?php if($col=="sex"){?> <?php} ?>*/
			'$this->stripvtags(\'<?php if( ${1}) { ?>\',\'(${2}) <?php } ?>\')',
			/*替换elseif的字符串<?php } elseif($col == "sex"){ ?> */
			'$this->stripvtags(\'<?php } elseif (${1}) { ?>\',"") ',
			/*替换else的字符串<?php } else { ?>*/
			'<?php }else{ ?>',
			/*一下两条用来替换模板中的loop标识符为foreach格式*/
			'<?php foreach($this->tpl_vars["${1}"])as $this->tpl_vars["${2}"]){ ?>${3}<?php } ?>',
			'<?php foreach($this->tpl_vars["${1}"]) as $this->tpl_vars["${2}"]=>$this->tpl_vars["${3}"]) { ?>${4}<?php } ?> ',
			/*替换include的字符串*/
			'file_get_contents($this->template_dir."/s{1}")'
		);
		/*使用正则替换函数*/
		$repContent = preg_replace($pattern,$replacement,$content);
		/*如果还有要替换的标识符递归调用再次替换*/
		if(preg_match('/'.$left.'([^('.$right.')]{1,})'.$right.'/',$repContent)){
			$repContent = $this->tpl_replace($repContent);
		}
		/*返回替换后的字符串*/
		return $repContent;
	}
	/*
		内部使用私有方法 ，用来将条件语句中使用的变量替换为对应的值
		@param string $expr 提供模板中条件语句的开始标记
		@param string $statement 提供模板中条件语句结束标记
		@return string      将处理后的条件语句相连后返回
	
	*/
	private function stripvtags($expr , $statement=''){
		/*匹配变量的正则*/
		$var_pattern = '/\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*/is';
		$expr = preg_replace($var_pattern , '$this->tpl_vars["${1}"]',$expr);
		/*将开始标记中的引号转义替换*/
		$expr = str_replace("\\\"","\"",$expr);
		/*替换语句和结束标记中的引号*/
		$statement = str_replace("\\\"","\"",$statement);
		return $expr.$statement;
		
	}

}


?>