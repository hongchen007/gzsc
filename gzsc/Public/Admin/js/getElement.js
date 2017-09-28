/*
	封装一个方法，获取html元素
		#ID
		.class
		&name
		*tagName
*/
function $(str){
	// console.log(str);

	// 声明对象
	var obj;

	// 用户想用户什么方式获取元素 --- 获取字符串的第一个字符
	// console.log(str[0]);

	// 第一个字符
	var first = str[0];

	// 传入的字符
	var eName = str.slice(1);

	switch(first){
		// ID 
		case '#':
			obj = document.getElementById(eName);
		break;

		// Class
		case '.':
			obj = document.getElementsByClassName(eName);
		break;

		// Name
		case '&':
			obj = document.getElementsByName(eName);
		break;

		// TagName
		case '*':
			obj = document.getElementsByTagName(eName);
		break;
	}

	// 返回对象
	return obj;
}