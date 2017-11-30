# zoho-crm-api-robin-pattern-lead-owner
Assigning robin-pattern-like effect to Zoho CRM lead


I was recently faced with an issue of not being able to use Zoho CRM's API robin pattern effect for assigning new lead owners to the leads inserted.

Note:
* This is only the code for assigning new owners in a robin-pattern-like effect.
* The users were grouped together in a profile in Zoho CRM. This was the only option in the API available at the time.

I thought I'd share my solution. Hopefully it will help anyone who's looking for it :) 

# Usage

* Add your Zoho API token to `zoho-team.php` on line 4

`$token="123456"; //Your token`

* Add your Zoho API token to `zoho-new-owner.php` on line 17

`$token="123456"; //Your token`

* Your teams profile name in `zoho-new-owner.php` on line 67

`if($sales == 'Sales')` //where 'Sales' is profile name for the team. 

I used this solution in conjuction with Wordpress Gravity Forms. 

If you would like to insert it into Gravity Forms, just take the result from `zoho-new-owner.php` and insert it into a hidden field via ajax or any other way. You can even do this with any other form.

If you need help or support, contact me here [web-designer.ninja](http://web-designer.ninja/)

`// Happy coding`


