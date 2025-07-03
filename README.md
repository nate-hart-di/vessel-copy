# Vessel 

Holds theme files for the Fletcher Jones group sites.

**Plugin managed by:** Tier II VIP

###Making changes to content inside of Vessel

Pull requests are **required**. We will review all pull requests immediately if you slack us directly.

Steps:

1) Create a new branch with your work
2) Push your changes to the repo
3) Create a pull request on the left hand side

Please version bump the last digit on site rebuilds in your pull request.

##Installing Vessel

1) Clone the repo into your `/wp-content/plugins/` folder
2) In terminal, CD into `vessel/content/vessel` and run `npm install` to install the necessary Gulp files
3) Run `gulp`
4) Make changes to the `/content/` folder as necessary 


###Sites using Vessel

| Name | URL | slug |
| ---: | :--- | --- |
| FJ Imports | https://www.fjimports.com | `fletcherjonesimports` |
| MB Newport | https://www.fjmercedes.com | `fletcherjonesmbnewport` |
| MB Chicago | https://www.mercedesbenzchicago.com | `fletcherjonesmercedesbenzchicago` |
| MB of Henderson | https://www.mbofhenderson.com | `fletcherjonesmercedesbenzofhenderson` |
| MB of Ontario | https://www.mbontario.com | `fletcherjonesmercedesbenzontario` |
| MB of Temecula | https://www.mbtemecula.com | `fletcherjonesmercedesbenztemecula` |
| MB of Fremont | https://www.mboffremont.com | `fletcherjonesmotorcarsoffremont` | 
| Porsche of Fremont | https://www.porscheoffremont.com | `porscheoffremont` |
| Fletcher Jones Nevada | http://www.fjnevada.com/ | `fletcherjonesnevada` |


###Notes

- LVRP No Results CTAs
	- SF-01304156
	- Jira: https://carsenterprise.atlassian.net/browse/SDWEB-8147
	- import settings from /assets/json/noResultsCTAs-to-use-with-idp-import.json
	- function: add_vrp_class() body class filter added in SharedFunctions 
	- _conditional-no-results-ctas.scss


## Updates
02459601 - Ryann Seither - Update Header Logo Sizing
02462892 - gkozicki - hide conversations sidebar icon on all pages