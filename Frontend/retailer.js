  document.addEventListener("DOMContentLoaded", () => {
        loadRetailerInfo();
    });
    
    function loadRetailerInfo() {
        // Mock existing retailer data (can be replaced with actual API or DB calls)
        const retailerData = {
            retailerID: "r000000",
            retailerName: "",
            retailerPhone: "00000000000",
            retailerEmail: "xxxxxx@gamil.com"
        };
    
        // Populate fields
        document.getElementById("retailerID").value = retailerData.retailerID;
        document.getElementById("retailerName").value = retailerData.retailerName;
        document.getElementById("retailerPhone").value = retailerData.retailerPhone;
        document.getElementById("retailerEmail").value = retailerData.retailerEmail;
    }
    
    function editRetailerInfo() {
        const retailerName = document.getElementById("retailerName").value;
        const retailerPhone = document.getElementById("retailerPhone").value;
        const retailerEmail = document.getElementById("retailerEmail").value;
    
        // Simple validation
        if (!retailerName || !retailerPhone || !retailerEmail) {
            alert("Please fill out all fields.");
            return;
        }
    
        // Save updated data (can be replaced with actual API or DB calls)
        const updatedRetailerData = {
            retailerName,
            retailerPhone,
            retailerEmail
        };
    
        console.log("Retailer information updated:", updatedRetailerData);
        alert("Retailer information saved successfully!");
    }
    
