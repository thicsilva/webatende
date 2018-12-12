import Inputmask from "inputmask";

var docNumber = document.getElementById('doc_number');
var phone = document.getElementById('phone');
Inputmask({"mask": ['999.999.999-99', '99.999.999/9999-99'], "keepstatic":true}).mask(docNumber);
Inputmask({"mask": ['(99)9999-9999', '(99)99999-9999'], "keepstatic":true}).mask(phone);
