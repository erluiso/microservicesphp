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

    if(inputVal === "")
    {
        alert("Please write a valid user id");
        return;
    }

    var response = sendRequest(URL_MICROSERVICE_1 + "/users/" + inputVal);

    refreshLogs();

    if(JSON.parse(response)["error"]["code"] == 1)
    {
        alert(JSON.parse(response)["error"]["message"]);
        return;
    }

    document.getElementById("result3").innerHTML = response;
}

/**
 * Loads initial users in the BBDD
 */
document.getElementById("loadUsers").onclick = function()
{
    var response = JSON.parse(sendRequest(URL_MICROSERVICE_1 + "/users/createTable"));

    refreshLogs();

    if(response["error"]["code"] == 1)
    {
        console.log(response["error"]["message"]);
        return;
    }

    document.getElementById("result1").innerHTML = response["message"];
};

/**
 * List all users
 */
document.getElementById("listUsers").onclick = function()
{
    var response = JSON.parse(sendRequest(URL_MICROSERVICE_1 + "/users"));

    refreshLogs();

    if(response["error"]["code"] === 1)
    {
        console.log(response["error"]["message"]);
        return;
    }
    
    var table = "";

    response["users"].forEach(function (user) 
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
 * Send a welcome email
 */
function sendEmail(userId)
{
    var response = JSON.parse(sendRequest(URL_MICROSERVICE_2 + "/emails/"+userId));

    refreshLogs();

    if(response["error"]["code"] === 1)
    {
        console.log(response["error"]["message"]);
        return;
    }

    console.log(response["message"]);
}

/**
 * Create the initial email table in the BBDD
 */
document.getElementById("loadEmails").onclick = function()
{
    var response = sendRequest(URL_MICROSERVICE_2 + "/emails/createTable");

    document.getElementById("result1").innerHTML = response;

    refreshLogs();
};
