/* Bangladesh geographic hierarchy used by Basha Khoj search.
   The national portal confirms 8 divisions and 64 districts; the upazila layer is fetched from a structured bilingual dataset.
*/
const BD_DIVISIONS = [
  {id:"barishal",name:"Barishal",bn:"বরিশাল",districts:["Barguna","Barishal","Bhola","Jhalakathi","Patuakhali","Pirojpur"]},
  {id:"chattogram",name:"Chattogram",bn:"চট্টগ্রাম",districts:["Bandarban","Brahmanbaria","Chandpur","Chattogram","Cumilla","Cox's Bazar","Feni","Khagrachhari","Lakshmipur","Noakhali","Rangamati"]},
  {id:"dhaka",name:"Dhaka",bn:"ঢাকা",districts:["Dhaka","Faridpur","Gazipur","Gopalganj","Kishoreganj","Madaripur","Manikganj","Munshiganj","Narayanganj","Narsingdi","Rajbari","Shariatpur","Tangail"]},
  {id:"khulna",name:"Khulna",bn:"খুলনা",districts:["Bagerhat","Chuadanga","Jashore","Jhenaidah","Khulna","Kushtia","Magura","Meherpur","Narail","Satkhira"]},
  {id:"mymensingh",name:"Mymensingh",bn:"ময়মনসিংহ",districts:["Jamalpur","Mymensingh","Netrokona","Sherpur"]},
  {id:"rajshahi",name:"Rajshahi",bn:"রাজশাহী",districts:["Bogura","Joypurhat","Naogaon","Natore","Chapainawabganj","Pabna","Rajshahi","Sirajganj"]},
  {id:"rangpur",name:"Rangpur",bn:"রংপুর",districts:["Dinajpur","Gaibandha","Kurigram","Lalmonirhat","Nilphamari","Panchagarh","Rangpur","Thakurgaon"]},
  {id:"sylhet",name:"Sylhet",bn:"সিলেট",districts:["Habiganj","Moulvibazar","Sunamganj","Sylhet"]}
];
const BD_UPAZILA_SOURCE="https://iqbalhasandev.github.io/bangladesh-geo-json/bangladesh-geo.json";
