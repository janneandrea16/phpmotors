//1) listen to the classifications select element to detect when a new classification is
//selected. When a change occurs it will ask the vehicles controller to fetch the vehicles
//from inventory for the classification and send them back
   
//2) when the inventory data is returned,
//it will send the data, as a JavaScript object, to a new JavaScript function to build the table structure around it,
//then inject it into the table that we just added to the inventory management view.
// Get a list of vehicles in inventory based on the classificationId 

//'use strict' directive tells the JavaScript parser to follow all rules strictly.
'use strict' 
 // Get a list of vehicles in inventory based on the classificationId 
 //Finds the classification select element in the vehicle management page based on its ID 
 let classificationList = document.querySelector("#classificationList"); 
 //Attaches the eventListener to the variable representing the classification select element and listens for any "change". When a change occurs an anonymous function is executed
 classificationList.addEventListener("change", function () { 
  //Captures the new value from the classification select element and stores it into a JavaScript variable.
  let classificationId = classificationList.value; 
  //ticks allow the value of a variable to be rendered within a string without the use of concatenation.
  console.log(`classificationId is: ${classificationId}`); 
  //getIncentory triggers case scenario and classificationId specifices which vehicle is needed
  let classIdURL = "/phpmotors/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId; 
  //The JavaScript "Fetch" which is a modern method of initiating an AJAX request
  fetch(classIdURL) 
  //waits for data to be returned from the fetch. The response object is passed into an anonymous function for processing
  .then(function (response) { 
   if (response.ok) { 
    return response.json(); 
   } 
   throw Error("Network response was not OK"); 
  }) 
  //Accepts the JavaScript object from line 12, and passes it as a parameter into an anonymous function.
  .then(function (data) { 
   //Sends the JavaScript object to the console log for testing purposes 
   console.log(data); 
   buildInventoryList(data); 
  }) 
  //captures any errors and sends them into an anonymous function
  .catch(function (error) { 
   console.log('There was a problem: ', error.message) 
  }) 
 })


// Build inventory items into HTML table components and inject into DOM 
function buildInventoryList(data){ 
    let inventoryDisplay = document.getElementById("inventoryDisplay"); 
    // Set up the table labels 
    let dataTable = '<thead>'; 
    dataTable += '<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>'; 
    dataTable += '</thead>'; 
    // Set up the table body 
    dataTable += '<tbody>'; 
    // Iterate over all vehicles in the array and put each in a row 
    data.forEach(function (element) { 
     console.log(element.invId + ", " + element.invModel); 
     dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`; 
     dataTable += `<td><a href='/phpmotors/vehicles?action=mod&invId=${element.invId}' title='Click to modify'>Modify</a></td>`; 
     dataTable += `<td><a href='/phpmotors/vehicles?action=del&invId=${element.invId}' title='Click to delete'>Delete</a></td></tr>`; 
    }) 
    dataTable += '</tbody>'; 
    // Display the contents in the Vehicle Management view uses DOM injection
    inventoryDisplay.innerHTML = dataTable; 
   }