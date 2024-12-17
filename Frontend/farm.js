document.addEventListener("DOMContentLoaded", () => {
    loadFarmInfo();
});

function loadFarmInfo() {

    const farmData = {
        farmID: "f000000",
        farmName: "Green Valley Farm",
        farmAddress: "123 Agro Street, Farmville",
        farmType: "crop",
        numFields: 1
    };

    document.getElementById("farmID").value = farmData.farmID;
    document.getElementById("farmName").value = farmData.farmName;
    document.getElementById("farmAddress").value = farmData.farmAddress;
    document.getElementById("farmType").value = farmData.farmType;
    document.getElementById("numFields").value = farmData.numFields;
}

function saveFarmInfo() {
    const farmName = document.getElementById("farmName").value;
    const farmAddress = document.getElementById("farmAddress").value;
    const farmType = document.getElementById("farmType").value;
    const numFields = document.getElementById("numFields").value;

    if (!farmName || !farmAddress || !farmType || !numFields) {
        alert("Please fill in all fields.");
        return;
    }

    const updatedFarmData = {
        farmName,
        farmAddress,
        farmType,
        numFields
    };

    console.log("Farm information updated:", updatedFarmData);
    alert("Farm information saved successfully!");
}
