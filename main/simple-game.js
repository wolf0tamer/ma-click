(function(elid, width, height, speed, strength){
    var canvas = document.querySelector(elid),
            ctx = canvas.getContext("2d"),
            pos = 0, blocks = [];
    canvas.width = width; canvas.height = height;
    ctx.fillStyle = "black";
    var game = setInterval(function(){
        if( Math.random() < strength) blocks.push([Math.random()*(width-10),-10]);
        ctx.clearRect(0,0,width,height);
        ctx.fillRect(pos,height-50,10,40);
        for(var i = 0; i < blocks.length; i++){
            ctx.fillRect(blocks[i][0],blocks[i][1],20,20);
            if( blocks[i][1] > height - 60 && blocks[i][1] < height - 10 && Math.abs( pos - blocks[i][0]) < 10 ){
                clearInterval(game);
                alert("Game over. You have " + Math.floor(1000 * strength) + " points.");
            }
            if( blocks[i][1] > height - 5 ){
                blocks.splice( i, 1);
                i--;
            } else {
                blocks[i][1] += 5;
            }
        }
        strength += 0.001;
    },speed);
    document.addEventListener('mousemove', function (e) {
        pos = (e.pageX > 0) ? ((e.pageX < width) ? e.pageX : width-10) : 0;
    }, false);
})("#canvas",700,700,42,0.07);