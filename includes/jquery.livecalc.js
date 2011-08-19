$(document).ready(function() {
    var numUsers = $("#estUsers");
    var costPerUser = $("#costPerUser");
    var monthly = $("#monthly");

    numUsers.keyup( function(e) {
        output_results(costPerUser, monthly, calculate(e.target.value));
    } );
});

function output_results(costPerUser, monthly, results) {
    costPerUser.val(number_to_currency(results[1], 2));
    monthly.val(number_to_currency(results[2]));
}

function calculate( num ) {
        var costPerUser = 0;
        var monthly = 0;

        if(!isNaN(num)) {
            if (num < 5){
                costPerUser = 2.99;
            }
            else if (num >= 5 && num < 10){
                costPerUser = 2.87;
            }
            else if (num >= 10 && num < 20){
                costPerUser = 2.75;
            }
            else if (num >= 20 && num < 30){
                costPerUser = 2.50;
            }
            else if (num >= 30 && num < 40){
                costPerUser = 2.32;
            }
            else if (num >= 40 && num < 50){
                costPerUser = 2.15;
            }
            else if (num >= 50 && num < 75){
                costPerUser = 1.99;
            }
            else if (num >= 75 && num < 100){
                costPerUser = 1.78;
            }
            else if (num >= 100 && num < 150){
                costPerUser = 1.66;
            }
            else if (num >= 150 && num < 200){
                costPerUser = 1.54;
            }
            else if (num >= 200 && num < 250){
                costPerUser = 1.49;
            }
            else if (num >= 250 && num < 300){
                costPerUser = 1.45;
            }
            else if (num >= 300 && num < 400){
                costPerUser = 1.42;
            }
            else if (num >= 400 && num < 500){
                costPerUser = 1.38;
            }
            else{
                costPerUser = 1.35;
            }
            monthly = costPerUser * num
        }
        else {
            num = 0;
            monthly = 0;
        }

        return new Array(num, costPerUser, monthly);
}