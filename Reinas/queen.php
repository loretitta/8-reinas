<!DOCTYPE html>
<html>
<script language="javascript" src="jquery-1.8.3.js"></script>
<body onload="createBtn()">
<h1>Chess Queens Problem</h1>
<hr>
Try to place the number of queens on an empty chess board so that no queen is "attacking" any other
<br>
( no two queens are in the same row, in the same column or along the same diagonal)
<br>
<hr>
Number of Queen(4-12)
<input type="text"  style="width:30px; height:15px;" id="txtN" value=8 />
<input type="button" id="btnN" value="Enter" onclick = "getN()" />
<br>
<div id ="cbtn" style = "width:400px;height:400px"></div>
<input type="button" id="btnWinner" value="ShowWinnerList" onclick = "showWinner()" />
<input type="button" id="btnSol" value="ShowSolution" onclick = "showSolution()" />  different solution with recursive method
<div id = "winner">Listhere</div>
<div id = "solution"></div>

<script>
var phpServerFile = "submituser.php";
var nMin=4;
var nMax=12;
var n=8;
var stopLoop = false;
var countQ=0;
var countCheck = new Array(nMax+1);
var btnValue = new Array(nMax+1);
var board = new Array(nMax+1);

var ansCol = new Array(nMax+1);
for (var i=1;i<=nMax;i++)
{
  btnValue[i]=new Array(nMax+1);
	board[i]=new Array(nMax+1);
}

for (var i=1;i<=nMax;i++)
{
	ansCol[i]=1;
	
}

function createBtn()
{
	
	var sc=""

	for (var i=1;i<=nMax;i++)
	{
		for (var j=1;j<=nMax;j++)
		{
			sc = sc+"<input type=\"button\" style=\"width:30px; height:30px;\" id=\"btnArray"+i+"a"+j+"\" value=\"   \" onclick = \"btnClick("+i+","+j+")\" />";
		}
		sc =sc+"<br>";
	}
	document.getElementById("cbtn").innerHTML=sc;

	getN();

	$(document).ready(function()
	{
		$("#winner").slideUp("slow");

	});
}


function getN()
{
	if ((document.getElementById("txtN").value>=nMin) && (document.getElementById("txtN").value<=nMax))
	{
		n = document.getElementById("txtN").value;
		resetBoard();
		buildBoard();
		
	}
	else
	{
		alert("Please enter number of Queens\nBetween "+nMin+" - "+nMax);
	}

}

function resetBoard()
{
	countQ =0;
         	for (var i=1;i<=nMax; i++) 
         	{
            		for (var j=1;j<=nMax; j++)
            		{
			document.getElementById("btnArray"+i+"a"+j).value="   ";
			document.getElementById("btnArray"+i+"a"+j).disabled=false;
			document.getElementById("btnArray"+i+"a"+j).style.visibility="hidden";
			btnValue[i][j]=0;
			board[i][j]=0;
                                   }
		countCheck[i]= false;
	}
}



function buildBoard()
{
	for(var i=1;i<=n;i++)
	{
		for(var j=1;j<=n;j++)
		{
			document.getElementById("btnArray"+i+"a"+j).style.visibility="visible";
		}
	}
}


function btnClick(ai,aj)
{
	var x = 0;
	var y = 0;
	x=ai;
	y=aj;
	if (document.getElementById("btnArray"+x+"a"+y).value == "   ")
	{
		
		
		var countCh = 1;
		while (countCheck[countCh])
		{
			countCh = countCh+1;
		}
		countCheck[countCh] = true;
		document.getElementById("btnArray"+x+"a"+y).value = countCh;
		btnValue[x][y] = btnValue[x][y]+1;

		countQ = countQ+1;
                		

		//disable in row
		for (var i=1;i<=n;i++)
                		{
                    		if(i != x)
                    		{
                        			btnValue[i][y]=btnValue[i][y]-1;
                            			document.getElementById("btnArray"+i+"a"+y).disabled=true;
                    		}
                		}

		//disable in col
		for (var j=1;j<=n;j++)
                		{
                    		if(j != y)
                    		{
                        			btnValue[x][j]=btnValue[x][j]-1;
                            			document.getElementById("btnArray"+x+"a"+j).disabled=true;
                    		}
                		}

		//disable upper left diagonal
                		var tmpX = x;
                		var tmpY = y;
                		while ((tmpX>1) && (tmpY>1))
                		{
                   		tmpX=tmpX-1;
                    		tmpY=tmpY-1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]-1;
                    
                        	document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=true;
                                
                		}
		
		//disable lower left diagonal
                		tmpX = x;
                		tmpY = y;
                		while ((tmpX<n) && (tmpY<n))
                		{
                   		tmpX=tmpX+1;
                    		tmpY=tmpY+1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]-1;
                    
                        	document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=true;
                                
                		}

		//disable upper right diagonal
                		tmpX = x;
                		tmpY = y;
                		while ((tmpX>1) && (tmpY<n))
                		{
                   		tmpX=tmpX-1;
                    		tmpY=tmpY+1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]-1;
                    
                        	document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=true;
                                
                		}

		//disable lower right diagonal
                		tmpX = x;
                		tmpY = y;
                		while ((tmpX<n) && (tmpY>1))
                		{
                   		tmpX=tmpX+1;
                    		tmpY=tmpY-1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]-1;
                    
                        	document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=true;
                                
                		}

		if (countQ == n)
		{
			conGratulation();
		}		
                
	}
	else
	{
		countQ = countQ-1;
		countCheck[document.getElementById("btnArray"+x+"a"+y).value] = false;
		document.getElementById("btnArray"+x+"a"+y).value = "   ";
		btnValue[x][y]=btnValue[x][y]-1;

		//enable in row
                		for (var i=1;i<=n;i++)
                		{
                    		if(i != x)
                    		{
                        			btnValue[i][y]=btnValue[i][y]+1;
                        			if (btnValue[i][y]>=0) 
                        			{
                            				document.getElementById("btnArray"+i+"a"+y).disabled=false;
                        			}
                    		}
                		}
	
		//enable in col
                		for (var j=1;j<=n;j++)
                		{
                    		if(j != y)
                    		{
                        			btnValue[x][j]=btnValue[x][j]+1;
                        			if (btnValue[x][j]>=0) 
                        			{
                            				document.getElementById("btnArray"+x+"a"+j).disabled=false;
                        			}
                    		}
                		}

		//enable in upper left diagonal
		var tmpX = x;
		var tmpY = y;

                		while ((tmpX>1) && (tmpY>1))
                		{
                    		tmpX=tmpX-1;
                    		tmpY=tmpY-1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]+1;
                    		if (btnValue[tmpX][tmpY]>=0) 
                    		{
                        			document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=false;
                    		}
                                
                		}


		//enable in lower left diagonal
		tmpX = x;
		tmpY = y;

                		while ((tmpX<n) && (tmpY<n))
                		{
                    		tmpX=tmpX+1;
                    		tmpY=tmpY+1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]+1;
                    		if (btnValue[tmpX][tmpY]>=0) 
                    		{
                        			document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=false;
                    		}
                                
                		}

		//enable in upper right diagonal
		tmpX = x;
		tmpY = y;

                		while ((tmpX>1) && (tmpY<n))
                		{
                    		tmpX=tmpX-1;
                    		tmpY=tmpY+1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]+1;
                    		if (btnValue[tmpX][tmpY]>=0) 
                    		{
                        			document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=false;
                    		}
                                
                		}

		//enable in lower right diagonal
		tmpX = x;
		tmpY = y;

                		while ((tmpX<n) && (tmpY>1))
                		{
                    		tmpX=tmpX+1;
                    		tmpY=tmpY-1;
                    		btnValue[tmpX][tmpY]=btnValue[tmpX][tmpY]+1;
                    		if (btnValue[tmpX][tmpY]>=0) 
                    		{
                        			document.getElementById("btnArray"+tmpX+"a"+tmpY).disabled=false;
                    		}
                                
                		}
	
	}
}

function showWinner()
{
	$(document).ready(function()
	{
		
		variableString = 'fname='+''+'&fqueen='+''+'&fdate='+'';

		$.post
		(
			phpServerFile,
			variableString,
			function(databack,status)
			{
				$("#winner").html(databack);
  				//alert("Data: " + databack + "\nStatus: " + status);
			}
		);


		$("#winner").slideToggle("slow");

				

	});

}

function submitUser(n,q,d)
{
	$(document).ready(function()
	{

		variableString = 'fname='+n+'&fqueen='+q+'&fdate='+d;

		$.post
		(
			phpServerFile,
			variableString,
			function(databack,status)
			{
				$("#winner").html(databack);
  				//alert("Data: " + databack + "\nStatus: " + status);
			}
		);
		
		//jQuery.ajax
		//({
		//	type: 'POST',
		//	url: 'submituser.php',
		//	data: variableString,
		//	function(databack,status)
		//	{
		//		$("#winner").text(databack);
  		//		alert("Data: " + data + "\nStatus: " + status);
		//	}
     		//});

		$("#winner").slideDown("slow");

	});
    	
}


function conGratulation()
{
	var myName = prompt("You win","Your name");
	var myDate = new Date();
	myDateD = myDate.toDateString();
	myDateT= myDate.toTimeString();
	myDateT = myDateT.split(" ");
	myDate=myDateD+" "+myDateT[0];
	if (myName !=null)
	{
		submitUser(myName,n,myDate);
	}
	
}

function showSolution()
{
	var c=confirm(" -_-\" try harder next time");
	if (c==true)
	{
		getN();
		stopLoop = false;
		findSol(1);
		ansCol[n]=ansCol[n]+1;
		if (ansCol[n] >n)
		{
			ansCol[n-1]=ansCol[n-1]+1;
		}
	}
	else
	{
		alert("Good, I know you can do it");
	} 
}

function findSol(aRowID)
{
	var rowID = 0;
	rowID = aRowID;
        
	if (ansCol[rowID] >n)
	{
		ansCol[rowID] =1;
	}
	
	while (ansCol[rowID]<=n)
	{
		if (board[rowID][ansCol[rowID]]== 0)
		{
			if (rowID == n)
			{
				printSol();
				stopLoop = true;
				return;
			}

			disBoard(ansCol[rowID],rowID);
			findSol(rowID+1);
			enBoard(ansCol[rowID],rowID);
		}
           		if (stopLoop)
		{
			return;	
		}
		ansCol[rowID] = ansCol[rowID]+1;
		
	}
	
	return;
}

function printSol()
{
	var tmp;
	tmp = ""
	var t = 1;
	var ansCopy = new Array(nMax+1); 
	for (var i=1;i<=nMax;i++)
	{
		ansCopy[i]=ansCol[i];
	
	}
	var myAnima = window.setInterval(function(){timeSol()},800);
	document.getElementById("btnSol").disabled=true;
	function timeSol()
	{
		tmp = tmp+"row = "+t+" column = "+ansCopy[t]+"<br>"; 
		$("#solution").html(tmp);
		btnClick(t,ansCopy[t]);
		 if (t == n-1)
		{
			window.clearInterval(myAnima);
			document.getElementById("btnSol").disabled=false;
		}
		t = t+1;
	}
}

function disBoard(x,y)
{
	//disable in column
	for (var i=y+1;i<=n;i++)
	{
		board[i][x]=board[i][x]-1;
	}
        
	var tmpX,tmpY;

        	//disable in lower left
        	tmpX = x;
        	tmpY = y;
        	while ((tmpX>1) && (tmpY<n))
        	{
		tmpX = tmpX-1;
		tmpY = tmpY+1;
		board[tmpY][tmpX]=board[tmpY][tmpX]-1;         
	}
        
	//disable in lower right
	tmpX = x;
	tmpY = y;
	while ((tmpX<n) && (tmpY<n))
	{
            		tmpX = tmpX+1;
		tmpY = tmpY+1;
		board[tmpY][tmpX]=board[tmpY][tmpX]-1;          
	}
}

function enBoard(x,y)
{
	//disable in column
	for (var i=y+1;i<=n;i++)
	{
		board[i][x]=board[i][x]+1;
	}
        
	var tmpX,tmpY;

        	//disable in lower left
        	tmpX = x;
        	tmpY = y;
        	while ((tmpX>1) && (tmpY<n))
        	{
		tmpX = tmpX-1;
		tmpY = tmpY+1;
		board[tmpY][tmpX]=board[tmpY][tmpX]+1;         
	}
        
	//disable in lower right
	tmpX = x;
	tmpY = y;
	while ((tmpX<n) && (tmpY<n))
	{
            		tmpX = tmpX+1;
		tmpY = tmpY+1;
		board[tmpY][tmpX]=board[tmpY][tmpX]+1;          
	}
}

</script>
</body>
</html>


