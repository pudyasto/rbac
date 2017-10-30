/* 
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */


function toast(message,title,typemessage = "info"){
    toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    toastr[typemessage](title,message);
}

function data_terbilang(bilangan) {
 
 if(bilangan==="" || bilangan==="0"){
     return "Nol Rupiah";
 }
 
 bilangan    = String(bilangan);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
 
 var panjang_bilangan = bilangan.length;
 
 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }
 
 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   angka[i] = bilangan.substr(-(i),1);
 }
 
 i = 1;
 j = 0;
 kaLimat = "";
 
 
 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {
 
   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";
 
   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = kata[angka[i+2]] + " Ratus";
     }
   }
 
   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = kata[angka[i]] + " Belas";
       }
     } else {
       kata2 = kata[angka[i+1]] + " Puluh";
     }
   }
 
   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = kata[angka[i]];
     }
   }
 
   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   }
 
   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = subkaLimat + kaLimat;
   i = i + 3;
   j = j + 1;
 
 }
 
 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }
 
 return kaLimat + "Rupiah";
}

function set_date(tahun,bulan,hari){    
    var d = new Date();
    
    if(Number(tahun) > d.getFullYear()){
        tahun = 0;
    }
    
    if(!(bulan)){
        bulan = 12;
    }else if(Number(bulan) === 0 && isNaN(bulan) === false){
        bulan = d.getMonth() + 1;
    }else if(Number(bulan) > 0 && isNaN(bulan) === false){
        bulan = (d.getMonth() - Number(bulan));
    }else if(Number(bulan) > 12 && isNaN(bulan) === false){
        bulan = 12;
    }else{
        bulan = 12;
    }
    
    if(!(hari)){
        hari = 31;
    }else if(Number(hari) === 0 && isNaN(bulan) === false){
        hari = d.getDate();
    }else if(Number(hari) > 0 && isNaN(bulan) === false){
        hari = d.getDate() - Number(hari);
    }else if(Number(hari) > 31 && isNaN(bulan) === false){
        hari = 31;
    }else{
        hari = 31;
    }
    
    
    var res = d.setFullYear(d.getFullYear() - Number(tahun));
    var newyear = new Date(res);
    var resdate = Number(hari) + "/" + Number(bulan) + "/" + newyear.getFullYear();
    return resdate;
}

var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
      var matches, substringRegex;

      // an array that will be populated with substring matches
      matches = [];

      // regex used to determine if a string contains the substring `q`
      substrRegex = new RegExp(q, 'i');

      // iterate through the pool of strings and for any string that
      // contains the substring `q`, add it to the `matches` array
      $.each(strs, function(i, str) {
        if (substrRegex.test(str)) {
          matches.push(str);
        }
      });

      cb(matches);
    };
  };