document.querySelector('#login').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission

  var form = event.target; // Get the form element
  var formData = new FormData(form); // Create a new FormData object with the form data

  var xhr = new XMLHttpRequest();
  var url = 'https://tarumt-calendar.samsam123.name.my/backend/login.php';

  xhr.open('POST', url, true);
  xhr.timeout = 5000;
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
    // if login success
    if (response.Status === 'Success') {
      alert('Login successful');
      // Save to localStorage
      localStorage.setItem('token', response.Data.Auth_Token); 
      localStorage.setItem('name', response.Data.Student_Name); 
      localStorage.setItem('id', response.Data.Student_ID); 
      localStorage.setItem('email', response.Data.Student_Email); 
      localStorage.setItem('deviceid', response.Data.Device_ID);
      localStorage.setItem('device', response.Data.Device);  
      window.location.href = './dashboard.html'; // Redirect to dashboard.html
    } else {
      alert(response.Data.Title + ': ' + response.Data.Message);
   
      // reload page
        window.location.href = 'index.html';
    }
    }
  };
  xhr.ontimeout = function() {
      alert('Request timed out. Please check your internet connection and try again.');
             // reload page
             window.location.href = 'index.html';
    };

    
  xhr.send(formData); // Send the form data as the request payload
  document.getElementById("loginbtn").innerHTML = '<span class="spinner-border" role="status"></span>';
});
