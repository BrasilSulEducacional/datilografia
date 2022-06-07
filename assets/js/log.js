function addRegister(data, log = "datilografia") {
    // if (log == "datilografia") {
    //     $.post("https://datilografia.brasilsuleducacional.com.br/source/log.php", {
    //         type: log,
    //         data: data
    //     }, function (response) {
    //         console.log(response)
    //     });

    //     return;
    // }

    // if (log == "texto") {
    //     $.post("https://datilografia.brasilsuleducacional.com.br/source/log.php", {
    //         type: log,
    //         data: data
    //     }, function (response) {
    //         console.log(response)
    //     });


    //     return;
    // }

    // if (log == "exercicio") {
    //     $.post("https://datilografia.brasilsuleducacional.com.br/source/log.php", {
    //         type: log,
    //         data: data
    //     }, function (response) {
    //         console.log(response)
    //     });


    //     return;
    // }

    $.post("https://datilografia.brasilsuleducacional.com.br/source/log.php", {
        type: log,
        data: data
    }, function (response) {
        console.log(response)
    });
}