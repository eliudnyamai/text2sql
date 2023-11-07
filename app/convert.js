// Function to fetch the bearer token from local storage
document.addEventListener("DOMContentLoaded", function () {
// Function to fetch the converted SQL using the bearer token
function getAuthToken() {
    return localStorage.getItem("access_token");
}
async function fetchConvertedSQL(sqlQuery) {
    const token = getAuthToken();

    if (!token) {
        console.error("No authentication token found.");
        return null; // Return early if there's no token
    }

    const apiUrl = "http://127.0.0.1:8000/api/convert-sql"; // Replace with your actual API URL

    // Example SQL query data
    const requestData = {
        sql_query: sqlQuery,
    };

    try {
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`,
            },
            body: JSON.stringify(requestData),
            mode: "cors", // Important for cross-origin requests
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        document.getElementById('outputSQL').innerHTML=data.sql;
        return data.sql; // Return the converted SQL
    } catch (error) {
        console.error("Error:", error);
        return null; // Handle the error and return null or an appropriate value
    }
}

// Example usage:
async function handleConvertButtonClick() {
    const sqlQuery = document.getElementById('inputText').value;
    const convertedSQL = await fetchConvertedSQL(sqlQuery);

    if (convertedSQL !== null) {
        // Handle the converted SQL, e.g., display it in the UI
        console.log("Converted SQL:", convertedSQL);
    } else {
        // Handle the case where the request failed or no token is available
        console.error("Failed to fetch converted SQL.");
    }
}

// Add an event listener to the button with id "convertbtn" in your extension's HTML
document.getElementById("convertButton").addEventListener("click", handleConvertButtonClick);

});
// Add an event listener to the button with id "convertbtn"


