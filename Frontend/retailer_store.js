document.addEventListener("DOMContentLoaded", () => {
    loadStoreInfo();
});

function loadStoreInfo() {
 
    const storeData = {
        storeName: "Store",
        storeAddress: "123 Green Street, Agro City"
    };

    // Populate fields
    document.getElementById("storeName").value = storeData.storeName;
    document.getElementById("storeAddress").value = storeData.storeAddress;
}

function saveStoreInfo() {
    const storeName = document.getElementById("storeName").value;
    const storeAddress = document.getElementById("storeAddress").value;

    
    if (!storeName || !storeAddress) {
        alert("Please fill out all fields.");
        return;
    }

  
    const updatedStoreData = {
        storeName,
        storeAddress
    };

    console.log("Store information updated:", updatedStoreData);
    alert("Store information saved successfully!");
}

