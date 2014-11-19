# SSL Test Script

This Scrip / Libary creates an easy way to check your SSL securtiy.
by using the excelent webservice of https://www.ssllabs.com/ssltest/

run the folowing commandline:

```
php ssltest.php --domain=example.com --minimum-rating=B --report-file=report.html
```

| option | required | Description |
| --- | --- | --- |
| **domain** | **yes** | the domain to check |
| minimum-rating | no | if rating is lower than mimimum rating the script exits with exit-code 1 instad of zero this allows for easy scriptability |
| report-file | no | the file where the full html of the ssllabs test report is written. |

