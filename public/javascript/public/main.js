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

function getWindowSize() {
    var container = document.getElementById("images");
    var width = window.innerWidth;
    var height = window.innerHeight;

    var columns = Math.floor(window.innerWidth / 240);
    var rows = Math.floor(window.innerHeight / 280);

    console.log((columns*rows)*2);
    return (columns*rows)*2;
}

function generateImages(data) {

    data.forEach(e => {
        var image = document.createElement("img");
        image.id = "img";
        image.className = "img"
        image.src = e.Url;

        //table
        var table = document.createElement("table");
        

        var tr1 = document.createElement("tr");
        var tr2 = document.createElement("tr");
        
        var tr3 = document.createElement("tr");

        var th1 = document.createElement("th");
        th1.colSpan = 2;
        th1.innerHTML = e.Name;
        th1.id = "imageName";

        var td2 = document.createElement("td");
        td2.width = 200;
        td2.height = 200;
        td2.colSpan = 2;
        td2.appendChild(image);

        var td3 = document.createElement("td");
        td3.innerHTML = e.Username;
        td3.id = "owner";

        var td4 = document.createElement("td");
        td4.innerHTML = 'D:'+e.Downloads;
        td4.id = "downloadCount";

        tr1.appendChild(th1);
        tr2.appendChild(td2);
        tr3.appendChild(td3);
        tr3.appendChild(td4);

        table.appendChild(tr1);
        table.appendChild(tr2);
        table.appendChild(tr3);

        var div = document.createElement("div");
        div.className = "image-container";

        div.appendChild(table);

        document.getElementById("images").appendChild(div);

/*
        var name = document.createElement("div");
        name.innerHTML = e.Name;
        name.id = "imageName";

        var user = document.createElement("div");
        user.innerHTML = e.Username;
        user.id = "owner";

        var details = document.createElement("div");
        details.id = "details";

        var downloadCount = document.createElement("div");
        downloadCount.innerHTML = 'D:'+e.Downloads;
        downloadCount.id = "downloadCount";

        var div = document.createElement("div");
        div.className = "image-container";

        details.appendChild(user);
        details.appendChild(downloadCount);

        div.appendChild(name);
        div.appendChild(image);
        div.appendChild(details);
        */
        //document.getElementById("images").appendChild(div);
    });
    console.log('resize');

    var imgElements = document.getElementsByTagName("img");

    Array.from(imgElements).forEach(element => {
        var width = element.width;
        var height = element.height;
        console.log(width);
        
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
        //console.log(element.height);
    });
}

(function() {
    var imgElements = document.getElementsByTagName("img");

    Array.from(imgElements).forEach(element => {
        var width = element.width;
        var height = element.height;
        console.log(width);
        
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
        //console.log(element.height);
    });
});

function getNumberOfImg() {
    var imgElements = document.getElementsByTagName("img");
    var count = 0;
    Array.from(imgElements).forEach(element => {
        count++;
    });
    return count;
}