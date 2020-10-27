(function() {
    var coll = document.getElementsByClassName("btn-container");

    //add event(s) to them
    for (var i = 0; i < coll.length; i++) {
        coll[i].addEventListener("mouseout", function() {

            var content = this.children[1];

            this.style.borderRadius = "10px";
                
            //set maxHeight
            content.style.maxWidth = null;

        });
        coll[i].addEventListener("mouseover", function() {
        
            this.classList.toggle("active");

            //select content(details) element
            var content = this.children[1];
                        
            //set maxHeight
            content.style.maxWidth = content.scrollWidth + "px";
            
        });
    }
});

function generateImages(data) {

    data.forEach(url => {
        var temp = document.createElement("img");
        temp.id = "img";
        temp.className = "img"
        temp.src = url;
        document.getElementById("image-container").appendChild(temp);
    });

    var imgElements = document.getElementsByTagName("img");

    Array.from(imgElements).forEach(element => {
        var width = element.width;
        var height = element.height;
        
        var maxWidth = 200;
        var maxHeight = 200;

        if(height > width) {
            element.height = maxHeight;
            element.width = maxWidth / (height / width);
            
        } else if(width > height) {
            element.width = maxWidth;
            element.height = maxHeight / (width / height);
        }else {
            element.height = maxHeight;
            element.width = maxWidth;
        }
    });
}

function getNumberOfImg() {
    var imgElements = document.getElementsByTagName("img");
    var count = 0;
    Array.from(imgElements).forEach(element => {
        count++;
    });
    return count;
}