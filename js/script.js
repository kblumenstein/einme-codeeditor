function isReady(){
	try {
    	localStorage.setItem("test", "test");
        localStorage.removeItem("test");
        
        return true;
    } catch(e) {
    	return false;
    }
}

function login(){
	var username = $("#username").val();
	var password = $("#password").val();
	
	// Check ob Felder leer
	if(username != "" && password != ""){
		var loginOption = $("input[name='loginOption']:checked").val();
		console.log(loginOption);
	
		$.ajax({
			type: "POST",
			url: "php/webservice.php?action=login",
			data: { user: username, password: password, loginOption: loginOption},
			dataType: "json",
			success: function(data){
				switch(data.status){
					case 0:
						// Login erfolgreich
						// speichere im Local Storage userDaten
						// leite auf nächste Seite weiter
						localStorage.setItem("loggedIn", true);
						localStorage.setItem("user", JSON.stringify(data.user));
						changeToPortal();
					break;
					case -1:
						localStorage.setItem("loggedIn", false);
						alert(data.statustext);
					break;
				}
				
			},
			error: function(err){
				console.log("error im AJAX-Login Call");
				console.log(err);
			}
		});
		
		
		
	}else{
		alert("Bitte gib eine Matrikelnummer und das dazugehörige Passwort an!");
	}
	
}

function saveLektion(){
	var aktLektion = splitLektion(localStorage.getItem("aktLektion"));
	var htmlCode = editor.getValue();
	var cssCode = editorCSS.getValue();
	
	var user = JSON.parse(localStorage.getItem("user"));
	
	$.each(user.lektionen, function(){
		if(aktLektion == this.lektion){
			this.code_html = htmlCode;
			this.code_css = cssCode;
		}
	});
	
	localStorage.setItem("user", JSON.stringify(user));
	
	$.ajax({
			type: "POST",
			url: "php/webservice.php?action=updateLektion",
			data: { user: user.matrikelnummer, lektion: aktLektion, html: htmlCode, css: cssCode},
			dataType: "json",
			success: function(data){
				console.log(data);
				switch(data.status){
					case 0:
						$("#console").html(data.statustext);
						$("#console").removeClass("error");
						$("#console").addClass("ok");
					break;
					case -1:
						$("#console").html(data.statustext);
						$("#console").addClass("error");
						$("#console").removeClass("ok");
					break;
					case -2:
						$("#console").html(data.statustext);
						$("#console").addClass("error");
						$("#console").removeClass("ok");
					break;
					
					
				}
				
				$("#console").fadeIn().delay(5000).fadeOut();
			},
			error: function(err){
				console.log("error im AJAX-UpdateLektion Call");
				console.log(err);
			}
		});
	
}

function logout(){
	localStorage.removeItem("loggedIn");
	localStorage.removeItem("user");
	changeToLogin();
}

function isLoggedIn(){
	return localStorage.getItem("loggedIn");
}

function changeToPortal(){
	location.href = "portal.html";
}

function changeToLogin(){
	location.href = "index.html";
}

function setCode(type, lektion){
	var user = JSON.parse(localStorage.getItem("user"));
	console.log(user);
	$.each(user.lektionen, function(){
		if(this.lektion == splitLektion(lektion)){
			switch(type){
				case "css":
					editorCSS.setValue(this.code_css);
				break;
				case "html":
					editor.setValue(stripslashes(this.code_html));
				break;
			}
		}
	});
}

function splitLektion(lektion, type){
	var lektionSplit;
	switch(type){
		case "li":
			lektionSplit = lektion.split("li-lektion-");
		break;
		default:
			lektionSplit = lektion.split("lektion-");
		break;
	}
	
	return lektionSplit[1];
}

function getLektion(lektion){
	var user = JSON.parse(localStorage.getItem("user"));
	var gibtsSchon = false;
	

	// Schau, ob Lektion lokal da		
	$.each(user.lektionen, function(){
		if(lektion == this.lektion){
			console.log(lektionObj);
			console.log(this.lektion);
			editor.setValue(stripslashes(this.code_html));
			editorCSS.setValue(this.code_css);
			$("#coding h2").html(lektionObj.lektionen[this.lektion-1].titel);
			gibtsSchon = true
		}
	});

	if(!gibtsSchon){
		$.ajax({
			type: "POST",
			url: "php/webservice.php?action=getLektion",
			data: { user: user.matrikelnummer, lektion: lektion},
			dataType: "json",
			success: function(data){

				switch(data.status){
					case 0:
						
						/*$("#console").html(data.statustext);
						$("#console").removeClass("error");
						$("#console").addClass("ok");*/
						
						var lektionRes = data.lektion[0];
						//console.log(lektionRes);
						editor.setValue(stripslashes(lektionRes.code_html));
						editorCSS.setValue(lektionRes.code_css);
						
						// Set Lektion in User-Obj im LocalStorage
						var user = JSON.parse(localStorage.getItem("user"));

						console.log("neue lektion");
						user.lektionen.push(lektionRes);
						
						localStorage.setItem("user", JSON.stringify(user));
						
					break;
					case -1:
						console.log(data.statustext);
						/*$("#console").html(data.statustext);
						$("#console").addClass("error");
						$("#console").removeClass("ok");*/
					break;
					case -2:
						console.log(data.statustext);
						/*$("#console").html(data.statustext);
						$("#console").addClass("error");
						$("#console").removeClass("ok");*/
					break;
				}
				
				//$("#console").fadeIn().delay(5000).fadeOut();
				


				
			},
			error: function(err){
				console.log("error im AJAX-UpdateLektion Call");
				console.log(err);
			}
		});
		
		$("#coding h2").html(lektionObj.lektionen[lektion-1].titel);
	}
}

function updateLektionenList(user){
	var html = "";
	var cssClass = "";
	//console.log(lektionObj);
	$.each(lektionObj.lektionen, function(){
		var outer = this;
		//console.log(outer);
		//console.log(user.lektionen);
		$.each(user.lektionen, function(){
			var inner = this;
			//console.log(inner);
			//console.log(outer.nummer + " " + inner.lektion);
			if(outer.nummer == inner.lektion){
				cssClass = "saved";
			}
		});
		html += "<li id='lektion-"+ outer.nummer +"' class='"+cssClass+"'>" + outer.titel +"</li>";
		cssClass = "";
	});
	//console.log(html);

	$("#allLektionen ul").html(html);

}

function checkHash(){
	var hash = location.hash;
	//console.log(hash);
	$("#nav li").removeClass("active");
	$("#navEditor li").removeClass("active");
	
	switch(hash){
		case "#coding":
			//console.log("coding");
			$("#allLektionen").hide();
			$("#admin").hide();
			$("#content h1").hide();
			$("#coding").show();
			location.hash = "coding";
			$("#saveButton").show();
			$("#resetButton").show();
			
			getLektion(splitLektion(localStorage.getItem("aktLektion")));
			$("#nav ul #lektion").addClass("active");
			$("#navEditor ul #liHTML").addClass("active");
		break;
		case "#administration":
			$("#allLektionen").hide();
			$("#coding").hide();
			$("#content h1").hide();
			$("#admin").show();
			location.hash = "administration";
			$("#nav ul #administration").addClass("active");
		break;
		case "#lektion":
			$("#allLektionen").show();
			location.hash = "lektion";
			$("#coding").hide();
			$("#content h1").hide();
			$("#admin").hide();
			$("#nav ul #lektion").addClass("active");
		break;
		default:
			$("#allLektionen h2").html("Verfügbare Lektionen");
			$("#allLektionen").show();
			//$("#content h1").hide();
			$("#nav ul #lektion").addClass("active");
		break;
	}	
}

function resetLektion(){
	var user = JSON.parse(localStorage.getItem("user"));
	var lektion = splitLektion(localStorage.getItem("aktLektion"));
	
	$.ajax({
			type: "POST",
			url: "php/webservice.php?action=resetLektion",
			data: { user: user.matrikelnummer, lektion: lektion},
			dataType: "json",
			success: function(data){

				switch(data.status){
					case 0:
						$("#console").html(data.statustext);
						$("#console").removeClass("error");
						$("#console").addClass("ok");
						
						var lektionRes = data.lektion[0];
						//console.log(lektionRes);
						editor.setValue(stripslashes(lektionRes.code_html));
						editorCSS.setValue(lektionRes.code_css);
						
						// Set Lektion in User-Obj im LocalStorage
						var user = JSON.parse(localStorage.getItem("user"));
						
						editor.setValue(stripslashes(lektionRes.code_html));
						editorCSS.setValue(stripslashes(lektionRes.code_css));
						
						$.each(user.lektionen, function(){
							//console.log(this.lektion + " -- " + lektionRes.lektion);
							if(this.lektion == lektionRes.lektion){
								//console.log("gleich");
								this.code_html = lektionRes.code_html;
								this.code_css = lektionRes.code_css;
							}
						});
						
						localStorage.setItem("user", JSON.stringify(user));
						
					break;
					case -1:
						$("#console").html("Lektion wurde zurückgesetzt!");
						$("#console").addClass("error");
						$("#console").removeClass("ok");

						var user = JSON.parse(localStorage.getItem("user"));
						
						$.each(user.lektionen, function(){
							//console.log(this.lektion +" -- " + lektion);
							if(this.lektion == lektion){
								editor.setValue(stripslashes(this.code_html));
								editorCSS.setValue(this.code_css);
							}
						});
						
					break;
					case -2:
						$("#console").html(data.statustext);
						$("#console").addClass("error");
						$("#console").removeClass("ok");
					break;
				}
				
				$("#console").fadeIn().delay(5000).fadeOut();

				
			},
			error: function(err){
				console.log("error im AJAX-UpdateLektion Call");
				console.log(err);
			}
		});
		
		$("#coding h2").html(lektionObj.lektionen[lektion-1].titel);
}

function stripslashes(str) {
	str=str.replace(/\\'/g,'\'');
	str=str.replace(/\\"/g,'"');
	str=str.replace(/\\0/g,'\0');
	str=str.replace(/\\\\/g,'\\');
	return str;
}

function getSnapOverview(){
	$.ajax({
			type: "GET",
			url: "../php/webservice.php?action=getSnapOverview",
			dataType: "json",
			success: function(data){
				switch(data.status){
					case 0:
						//console.log(data.snap);
						
						var html = "<table><thead><td></td><td>Matrikelnummer</td><td>Punkte</td><td>Datum</td>";
						var count = 0;
						$.each(data.snap, function(){
							count++;
							html += "<tr><td>"+count+".</td><td>"+this.matrikelnummer+"</td><td>"+this.punkte+"</td><td>"+this.timestamp+"</td></tr>";
						});
						
						html += "</table>";
						$("#overview").html(html);
					break;
					case -1:
						alert(data.statustext);
					break;
				}
				
			},
			error: function(err){
				console.log("error im AJAX-SnapOverview Call");
				console.log(err);
			}
		});
}

function getSnapMatrikelnummern(){
	$.ajax({
			type: "GET",
			url: "../php/webservice.php?action=getSnapMatrikelnummern",
			dataType: "json",
			success: function(data){
				switch(data.status){
					case 0:
						//console.log(data.snap);
						
						var html = "<option>Wähle eine Matrikelnummer</option>";
						var matrikelnummern = new Array();
						$.each(data.snap, function(){
							if(matrikelnummern.indexOf(this.matrikelnummer)== -1){
								console.log(this.matrikelnummer);
								html += "<option>"+this.matrikelnummer+"</option>";
								matrikelnummern.push(this.matrikelnummer);
							}
						});
						
						$("#matrikelnummer").html(html);
					break;
					case -1:
						alert(data.statustext);
					break;
				}
				
			},
			error: function(err){
				console.log("error im AJAX-SnapMatrikelnummern Call");
				console.log(err);
			}
		});
}

function getSnapFragen(matrikelnummer){
	$.ajax({
			type: "POST",
			url: "../php/webservice.php?action=getSnapFragen",
			data: { user: matrikelnummer},
			dataType: "json",
			success: function(data){
				switch(data.status){
					case 0:
						console.log(data.snap);
						
						var html = "<thead><td></td><td>Matrikelnummer</td><td>Frage</td><td>Antwort</td><td>Datum</td></thead>";
						var count = 0;
						$.each(data.snap, function(){
							count++;
							html += "<tr class='richtig"+this.richtig+"'><td>"+count+".</td><td>"+ this.matrikelnummer+"</td><td>"+fragenAntworten[this.frage-1][0]+"</td><td>"+fragenAntworten[this.frage-1][1][this.antwort-1]+"</td><td>"+this.timestamp+"</td></tr>";
						});

						
						$("#fragen").html(html);
					break;
					case -1:
						alert(data.statustext);
					break;
				}
				
			},
			error: function(err){
				console.log("error im AJAX-SnapMatrikelnummern Call");
				console.log(err);
			}
		});
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}