// Check if required values are missing in localStorage
if (!localStorage.getItem('deviceid') || !localStorage.getItem('email') || !localStorage.getItem('device') || !localStorage.getItem('name') || !localStorage.getItem('token') || !localStorage.getItem('id')) {
  alert('Please Login');
  window.location.href = './login.html'; // Redirect to login.html
}

// Logout

function logout() {
  localStorage.clear(); // Clear all items from localStorage
  alert('Logout successful');
  window.location.href = './login.html'; // Redirect to login.html
}

// Verify Token

function verifytoken(){
  var token = localStorage.getItem('token');
  var xhr = new XMLHttpRequest();
  var url = 'https://tarumt-calendar.samsam123.name.my/backend/validate.php';

  xhr.open('POST', url, true);

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if(response.Status == 'Success'){
            // Do nothing
          }
      } else {
          alert("Token expired.\nPlease relogin with your username and password.");
          localStorage.clear(); // Clear all items from localStorage
          window.location.href = './login.html'; // Redirect to login.html
      }
    }
  };

  var formData = new FormData();
  formData.append('token', token);

  xhr.send(formData);
}

// Generate ICS

function generateICS() {
  var token = localStorage.getItem('token');
  var studentname = localStorage.getItem('name');

  var xhr = new XMLHttpRequest();
  var url = 'https://tarumt-calendar.samsam123.name.my/backend/generateics.php';

  xhr.open('POST', url, true);

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
         // Update the #notes element with a message
  document.getElementById('notes').innerHTML = 'Generated successfully. Please check your Downloads to get the iCalendar (.ics) file.';
 // Save the file with the provided filename
var blob = new Blob([xhr.response], { type: 'text/calendar' });
var downloadLink = document.createElement('a');
downloadLink.href = window.URL.createObjectURL(blob);
downloadLink.download = studentname + '.ics'; // Replace with the desired filename
downloadLink.click();
      } else {
          alert(response.Data.Title + ': ' + response.Data.Message);
          window.location.href = './login.html'; // Redirect to login.html
      }
    }
  };

  var formData = new FormData();
  formData.append('token', token);
  formData.append('studentname', studentname);

  xhr.send(formData);

  // Update the #notes element with a message
  document.getElementById('notes').innerHTML = 'The generate process has been initiated. Please wait for 10-30 seconds for the iCalendar file to be generated. <span class="spinner-border" role="status"></span>';


}

// Retrieve content
  var deviceid = localStorage.getItem('deviceid');
  var email = localStorage.getItem('email');
  var device = localStorage.getItem('device');
  var name = localStorage.getItem('name');
  var token = localStorage.getItem('token');
  var id = localStorage.getItem('id');

  // Put into elementID
  document.getElementById('studentname').innerHTML = name;
  document.getElementById('studentnamebig').innerHTML = name;
  document.getElementById('studentemail').innerHTML = email;
  document.getElementById('deviceid').innerHTML = deviceid;
  document.getElementById('studentid').innerHTML = id;
