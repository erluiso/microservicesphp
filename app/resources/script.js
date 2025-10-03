var URL_MICROSERVICE_1 = "http://127.0.0.2";
var URL_MICROSERVICE_2 = "http://127.0.0.3";

/**
 * Load initial data
 */
window.onload = function()
{
    refreshLogs();
}

/**
 * Refresh the logs
 */
function refreshLogs()
{
    var iframe = document.getElementById('msUsersLogs');
    iframe.src = URL_MICROSERVICE_1 + "/log/logs.log?rand=" + Date.now();

    var iframe = document.getElementById('msEmailsLogs');
    iframe.src = URL_MICROSERVICE_2 + "/log/logs.log?rand=" + Date.now();
}

/**
 * resetLogsUsersMs
 */
document.getElementById("resetLogsUsersMs").onclick = function()
{
    sendRequest(URL_MICROSERVICE_1 + "/resetLogs");
    refreshLogs();
}

/**
 * resetLogsEmailsMs
 */
document.getElementById("resetLogsEmailsMs").onclick = function()
{
    sendRequest(URL_MICROSERVICE_2 + "/resetLogs");
    refreshLogs();
}

/**
 * Search and load a user by id
 */
document.getElementById("searchUser").onclick = function()
{
    var inputVal = document.getElementById("userId").value;

    if(!inputVal.trim().length || isNaN(inputVal))
    {
        alert("Please, insert a user id valid.");
        return;
    }
    
    var response = sendRequest(URL_MICROSERVICE_1 + "/users/" + inputVal);

    document.getElementById("result3").innerHTML = response;
    refreshLogs();
}

/**
 * Loads initial users in the BBDD
 */
document.getElementById("loadUsers").onclick = function()
{
    var response = sendRequest(URL_MICROSERVICE_1 + "/users/createTable");

    document.getElementById("result1").innerHTML = response;
    refreshLogs();
};

/**
 * List all users
 */
document.getElementById("listUsers").onclick = function()
{
    var response = JSON.parse(sendRequest(URL_MICROSERVICE_1 + "/users"));

    var table = "";

    response.forEach(function (user) 
    {
        table += "<tr>";
        table += "  <td>"+user.id+"</td>";
        table += "  <td>"+user.name+"</td>";
        table += "  <td>"+user.email+"</td>";
        table += "  <td>"+user.date+"</td>";
        table += "  <td><button id='send' onclick='sendEmail("+user.id+")'>Send email</button></td>";
        table += "</tr>";
    });

    document.getElementById("users").innerHTML = table;
    refreshLogs();
}

/**
 * Sends request by Ajax
 */
function sendRequest($url)
{
    var xhr = new XMLHttpRequest();
    xhr.open("GET", $url, false);
    xhr.send();

    // stop the engine while xhr isn't done
    for(; xhr.readyState !== 4;)
    {
        if (xhr.status !== 200) 
        {
            console.warn('request_error');
        }
    }
    return xhr.responseText;
}

/**
 * Return if a value is a number
 */
function isNumber(value) 
{
    return !isNaN(value) && typeof value === 'number';
}

/**
 * Send a welcome email
 */
function sendEmail(userId)
{
    var response = sendRequest(URL_MICROSERVICE_2 + "/emails/"+userId);

    if(response === "ko")
    {
        alert("Error to send email");
    }

    refreshLogs();
}

/**
 * Create the initial table in the BBDD
 */
document.getElementById("loadEmails").onclick = function()
{
    var response = sendRequest(URL_MICROSERVICE_2 + "/emails/createTable");

    document.getElementById("result1").innerHTML = response;
    refreshLogs();
};
