<?php

class MyTpl{
	public $template_dir = "templates";
	public $compile_dir = "templates_c";
	public $left_delimiter =  "<{";
	public $right_delimiter = "}>";
	private $tpl_vars = array();
	/*
		��php�еķ���ֵ�ᱣ�浽��Ա����$tpl_vars�����ڽ��������Ӧ�ı��������滻
		@param string $tpl_vars ��Ҫһ���ַ���������Ϊ�����±꣬Ҫ��ģ���еı�������Ӧ
		@param string $value ��Ҫһ���������͵�ֵ�����������ģ���еı�����ֵ
	*/

	function assign($tpl_var , $value= null){
		if($tpl_var != ""){
			$this->tpl_vars[$tpl_var] = $value ;
		}
	}
	/*
		����ָ��Ŀ¼��ģ���ļ��������滻���������������ļ���ŵ���һ��ָ��Ŀ¼��
		@param string $fileName  �ṩģ���ļ���
	*/
	function display($fileName){
		//var_dump(file_exists("home/".$this->template_dir."/index.html"));
		//die("jieshu");
		/*��ָ����Ŀ¼Ѱ��ģ���ļ�*/
		$tplFile = $this->template_dir."/".$fileName;
		if(!file_exists($tplFile)){
			die("ģ���ļ�{$tplFile}������");
		}
		/*	��ȡ��ϵ�ģ���ļ������ļ������ݶ��Ǳ��滻����*/
		$comFileName = $this->compile_dir."/com_".$fileName.".php";
		/*�ж��滻����ļ��Ƿ���ں�ʵ���ڵ��иĶ�*/
		if( !file_exists($comFileName) || filemtime($comFileName) < filemtime($tplFile)){
			/*�����ڲ��滻ģ�巽��*/
			$repContent = $this->tpl_replace(file_get_contents($tplFile));
			/*������ϵͳ��Ϻ�Ľű��ļ�*/
			file_put_contents($comFileName,$repContent);
		}
			/*����������ģ���ļ�������ͻ�*/
			include($comFileName);
		
	}
	/*
		�ڲ�ʹ�õ�˽�з�����ʹ��������ʽ��ģ���ļ�'<{}>'�е�����滻�ɶ�Ӧ��ֵ����php����
		@param string $content �ṩ��ģ���ļ������ȫ�������ַ���
		@return $repContent    �����滻����ַ���
	*/
	private function tpl_replace($content){
		/*�����Ҷ�������У���Ӱ��������������ת�� ���磬<{}>ת���\<\{\}\>*/
		$left = preg_quote($this->left_delimiter,"/");
		$right = preg_quote($this->right_delimiter,"/");
		/*ƥ��ģ���и��ֱ�ʾ����������ʽ��ģʽ����*/
		$pattern = array(
			/*ƥ��ģ���б���,���磬��<{ $valr }>��*/
			'/'.$left.'\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*'.$right.'/i',
			/*ƥ��ģ����if��ʾ��������"<{if $col=="sex"}><{/if}>"*/
			'/'.$left.'\s*else\s*if\s*(.+?)\s*'.$right.'(.+?)'.$left.'\s*\/if\s*'.$right.'/ies',
			/*ƥ��else��ʾ��,����"<{ else }>"*/
			'/'.$left.'\s*else\s*'.$right.'/is',
			/*����ƥ��ģ���е�loop��ʾ�����������������е�ֵ������"<{ loop $arrs $value }><{ /loop }>"*/
			'/'.$left.'\s*loop\s+\$(\s+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s'.$right.'(.+?)'.$left.'\s*\/loop\s*'.$right.'/is',
			/*�������������еļ���ֵ������"<{ loop $arrs $key => $vaule }><{ \loop }>"*/
			'/'.$left.'\s*loop\s+\$(\s+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*=>\s*\$(\s+)\s*'.$right.'(.+?)'.$left.'\s*\/loop \s*'.$right.'/is',
			/*ƥ��include��ʾ�������磬"<{ include "header.html" }>"*/
			'/'.$left.'\s*include\s+[\"\']?(.+?)[\"\']?\s*'.$right.'/ie'
		);
		$replacement = array(
			/* �滻ģ���еı���<?php echo $this->tpl_vars["var"] ?> */
			'<?php echo $this->tpl_vars["${1}"]; ?>',
			/*�滻ģ���е�if�ַ���<?php if($col=="sex"){?> <?php} ?>*/
			'$this->stripvtags(\'<?php if( ${1}) { ?>\',\'(${2}) <?php } ?>\')',
			/*�滻elseif���ַ���<?php } elseif($col == "sex"){ ?> */
			'$this->stripvtags(\'<?php } elseif (${1}) { ?>\',"") ',
			/*�滻else���ַ���<?php } else { ?>*/
			'<?php }else{ ?>',
			/*һ�����������滻ģ���е�loop��ʶ��Ϊforeach��ʽ*/
			'<?php foreach($this->tpl_vars["${1}"])as $this->tpl_vars["${2}"]){ ?>${3}<?php } ?>',
			'<?php foreach($this->tpl_vars["${1}"]) as $this->tpl_vars["${2}"]=>$this->tpl_vars["${3}"]) { ?>${4}<?php } ?> ',
			/*�滻include���ַ���*/
			'file_get_contents($this->template_dir."/s{1}")'
		);
		/*ʹ�������滻����*/
		$repContent = preg_replace($pattern,$replacement,$content);
		/*�������Ҫ�滻�ı�ʶ���ݹ�����ٴ��滻*/
		if(preg_match('/'.$left.'([^('.$right.')]{1,})'.$right.'/',$repContent)){
			$repContent = $this->tpl_replace($repContent);
		}
		/*�����滻����ַ���*/
		return $repContent;
	}
	/*
		�ڲ�ʹ��˽�з��� �����������������ʹ�õı����滻Ϊ��Ӧ��ֵ
		@param string $expr �ṩģ�����������Ŀ�ʼ���
		@param string $statement �ṩģ�����������������
		@return string      ��������������������󷵻�
	
	*/
	private function stripvtags($expr , $statement=''){
		/*ƥ�����������*/
		$var_pattern = '/\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*/is';
		$expr = preg_replace($var_pattern , '$this->tpl_vars["${1}"]',$expr);
		/*����ʼ����е�����ת���滻*/
		$expr = str_replace("\\\"","\"",$expr);
		/*�滻���ͽ�������е�����*/
		$statement = str_replace("\\\"","\"",$statement);
		return $expr.$statement;
		
	}

}


?>