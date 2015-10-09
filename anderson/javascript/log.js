function logIntoServer(log){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var query = generateSQL(log);
	var i=0;
	while(i<log.length){
		q = "";
		while(q.length<2000 && i<log.length){
			q+=query[i];
			i++;
		}
		xmlhttp.open("GET","ajax_log.php?query="+q,false);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange=function(){
			 if (xmlhttp.readyState==4 && xmlhttp.status==200){ 
			} 
		}
		xmlhttp.onerror=function(){
			alert(xmlhttp.responseText);
		}
		//alert(xmlhttp.status);
		xmlhttp.send();
		//alert(xmlhttp.status);
	}
}
function uploadFile(name,pic){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var query = "INSERT INTO UPLOAD(`filename`,`file`)VALUES('"+name+"','"+pic+"')";
	xmlhttp.open("post","ajax_save.php",false);
	xmlhttp.setRequestHeader('Content-Type', 'application/upload');
	xmlhttp.onreadystatechange=function(){
		 if (xmlhttp.readyState==4 && xmlhttp.status==200){ 
		} 
	}
	xmlhttp.onerror=function(){
		alert(xmlhttp.responseText);
	}
	xmlhttp.send(query);
}
function getSQLTimeString(date){
	return date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+':'+date.getMilliseconds();
}
function logProgress(subject,student,progress){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var query="UPDATE ENROL SET progress = CASE WHEN "+progress+" > progress THEN "+progress+" ELSE progress END WHERE studentID = "+student+" AND subjID = "+subject+";";
	xmlhttp.open("GET","ajax_log.php?query="+query,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}
function generateSQL(log){
	var query=[];
	for(var i=0; i<log.length;i++ ){
		query[i] = "INSERT INTO LOG(`studentID`,`phaseID`,`time`,`actionType`,`correct`,`action`,`duration`,`target1`,`target2`,`sessionID`)VALUES("+log[i][0]+","+log[i][1]+",'"+log[i][2]+"','"+log[i][3]+"'";
		for(var j=4;j<=9;j++){
			if(log[i][j]=='null'){
				query[i] += ",NULL";
			} else {
				(j==4||j==6)?query[i] += ","+log[i][j]+"":query[i] += ",'"+log[i][j]+"'";
			}
		}
		query[i] += ");";
	}
	return query;
}