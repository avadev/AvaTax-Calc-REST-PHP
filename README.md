AvaTax-Calc-REST-PHP
====================

PHP sample for the AvaTax Calc REST API.

Core classes are located in /AvaTax4PHP/classes.

To run a sample, you will need to enter your credentials in the sample file itself (e.g. /API-Samples/validate.php).

Some Windows users have had trouble with cURL automatically using our SSL certificate. The sample code offers 
two workarounds (both in /AvaTax4PHP/classes/TaxServiceRest.php.class). If this is something that presents a challenge
for your system, uncomment ONE of the following two options in that file:

		//Some Windows users have had trouble with our SSL Certificates. Uncomment the following line to NOT use SSL.
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 		
		
		//Other Windows users may prefer to download the certificate from our site (detail here: ) and manually set the cert path.
		//    To set the path manually, uncomment the following two lines. If you choose to manually set the path, make sure you have commented out the line above 
		//    that tells curl to NOT use SSL.
		//$ca = "C:/curl/curl-ca-bundle.crt";
		//curl_setopt($curl, CURLOPT_CAINFO, $ca);