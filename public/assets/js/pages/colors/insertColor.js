let range0 = document.getElementById("Range0");
let range1 = document.getElementById("Range1");
let range2 = document.getElementById("Range2");
let colorResult = document.getElementById("resultColor");


function showColor() {
    document.getElementById("rgb").value = colorResult.style.backgroundColor = "rgb(" + range0.value + "," + range1.value + "," + range2.value + ")";
    colorResult.style.backgroundColor = "rgb(" + range0.value + "," + range1.value + "," + range2.value + ")";
}



const ranges = document.querySelectorAll(".form-range");
ranges.forEach(function(button){
    button.addEventListener("click", function(Event){
        showColor();
    })
});

