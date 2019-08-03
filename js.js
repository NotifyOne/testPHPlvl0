for (i = 0; i < document.getElementsByTagName("table").length; i++) {
    document.getElementsByTagName("table")[i].addEventListener("change", f);
}

function f() {
    var tables = document.getElementsByTagName("table");

    tlen = tables.length;
    for (i = 0; i < tlen; i++) {
        trlen = tables[i].rows.length;

        for (j = 1; j < trlen; j++) {

            trc = tables[i].rows[j].cells; // cells
            trclen = trc.length;

            for (h = 1; h < trclen; h++) {

                cell = trc[h];

                input = cell.getElementsByTagName('input')[0];
                if ((h == 4) || (h == 8) || (h == 12) || (h == 16)) {
                    value = (
                        trc[h - 3].getElementsByTagName('input')[0].value
                        - -trc[h - 2].getElementsByTagName('input')[0].value
                        - -trc[h - 1].getElementsByTagName('input')[0].value);
                    if (value == 0) {
                        input.value = 0;
                    } else {
                        input.value = (value + 1) / 3;
                    }
                } else if (h == 17) {
                    value = (
                        trc[4].getElementsByTagName('input')[0].value
                        - -trc[8].getElementsByTagName('input')[0].value
                        - -trc[12].getElementsByTagName('input')[0].value
                        - -trc[16].getElementsByTagName('input')[0].value);
                    if (value == 0) {
                        input.value = 0;
                    } else {
                        input.value = (value + 1) / 4;
                    }
                }
            }
        }
    }
}