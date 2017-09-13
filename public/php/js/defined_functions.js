function cancel(url) {window.location.href=url; }
function back() { window.history.back(); }
function ValidateEmail(email)
{
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return expr.test(email);
}
function Validatephone(strString)
{
   var strValidChars = "0123456789+-() ";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

  
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnResult = false;
         }
      }
   return blnResult;
}
function ValidateFname(param)
{
    return (param.length<2)?false:true;
}
function ValidateLname(param)
{
    return (param.length<2)?false:true;
}
function Validatenric(param)
{
    return (param.length<5)?false:true;
}

function ValidatePassword(param)
{
    return (param.length < 6)?false:true;
}


function clear_msg_center(p)
{
    if(p)
    {
        $("#msg_center").html("&nbsp;");
    }
    else
    {
        $("#msg_center").fadeOut(300);
        $("#msg_center").fadeIn(300);
        $("#msg_center").fadeOut(300);
        $("#msg_center").fadeIn(300);
        $("#msg_center").fadeOut(300);
        $("#msg_center").fadeIn(300);
        setTimeout('clear_msg_center(1)',5000);
    }

    //
    //document.getElementById('msg_center').innerHTML="&nbsp;";
}

function scorePassword(pass)
{
    var score = 0;
    if (!pass)
        return score;

    // award every unique letter until 5 repetitions
    var letters = new Object();
    for (var i=0; i<pass.length; i++)
    {
        letters[pass[i]] = (letters[pass[i]] || 0) + 1;
        score += 5.0 / letters[pass[i]];
    }

    // bonus points for mixing it up
    var variations =
    {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass)
    }

    variationCount = 0;
    for (var check in variations) {
        variationCount += (variations[check] == true) ? 1 : 0;
    }
    score += (variationCount - 1) * 10;

    return parseInt(score);
}

function checkPassStrength(pass)
{
    var score = scorePassword(pass);
    if(score > 99)
    {
        $("#pass_meater").html('Password Strangth: <span class="very-strong">Very Strong</span>');
    }
    else if(score > 79)
    {
        $("#pass_meater").html('Password Strangth: <span class="strong">Strong</span>');
    }
    else if(score > 59)
    {
        $("#pass_meater").html('Password Strangth: <span class="medium">Moderate</span>');
    }
    else if(score > 39)
    {
        $("#pass_meater").html('Password Strangth: <span class="normal">Normal</span>');
    }
    else if(score > 19)
    {
        $("#pass_meater").html('Password Strangth: <span class="weak">Weak</span>');
    }
    else
    {
        $("#pass_meater").html('Password Strangth: <span class="weak">Weak</span>');
    }
}

function checkTime(i)
{
    if (i<10)
    {
        i="0" + i;
    }
    return i;
}
function displayTime(h,m)
{
    var diem = "AM";
    if (h == 0) {
        h = 12;
    } else if (h > 12) {
        h = h - 12;
        diem="PM";
    }
    h=checkTime(h);
    m=checkTime(m);

    var myClock = document.getElementById('clockDisplay');
    myClock.textContent = h + ":" + m + " " + diem;
    myClock.innerText = h + ":" + m + " " + diem;
}
function renderTime(h,m)
{
    //alert('aa');

    m++;
    if(m>59)
    {
        h++;
        m=0;
    }
    if(h>23)
    {
        h=0;
    }
    setTimeout('renderTime('+h+','+m+')',60000);
    displayTime(h,m);
}

    //callrenderTime();
setTimeout('clear_msg_center(0)',2000);











