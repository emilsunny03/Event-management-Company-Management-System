function validateForm() {
    // Get form elements
    const cin = document.getElementById("cin");
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");
    const address = document.getElementById("address");
    const city = document.getElementById("city");
    const state = document.getElementById("state");
    const country = document.getElementById("country");
    const pincode = document.getElementById("pincode");
    const companyName = document.getElementById("company_name");
    const services = document.getElementById("services");
    const employees = document.getElementById("employees");
    const yearsExperience = document.getElementById("years_experience");
    const about = document.getElementById("about");
  
    // Validate fields
    let isValid = true;
  
    // Add validations for new fields
    if (companyName.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid company name.");
    }
  
    if (services.value.trim() === "") {
      isValid = false;
      alert("Please enter valid services offered.");
    }
  
    if (employees.value.trim() === "" || parseInt(employees.value) < 1) {
      isValid = false;
      alert("Please enter a valid number of employees (must be greater than 0).");
    }
  
    if (yearsExperience.value.trim() === "" || parseInt(yearsExperience.value) < 0) {
      isValid = false;
      alert("Please enter a valid number of years of experience (cannot be negative).");
    }
  

  
    // Existing validations for CIN, email, phone, address, city, state, country, and pincode
    if (cin.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid CIN.");
    }
  
    if (!isEmailValid(email.value)) {
      isValid = false;
      alert("Please enter a valid email address.");
    }
  
    if (phone.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid phone number.");
    }
  
    if (address.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid address.");
    }
  
    if (city.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid city.");
    }
  
    if (state.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid state.");
    }
  
    if (country.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid country.");
    }
  
    if (pincode.value.trim() === "") {
      isValid = false;
      alert("Please enter a valid pincode.");
    }
  
    // Return validation result
    return isValid;
  }
  
  // Helper function to validate email
  function isEmailValid(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }