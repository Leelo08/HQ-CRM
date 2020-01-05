@component('mail::message')

# New Company is added!

<p>Company Information</p>
<strong>Company Name: </strong> {{ $newCompany['name'] }}
<br />
<strong>Company Email: </strong> {{ $newCompany['email'] }}
<br />
<strong>Company Website: </strong> {{ $newCompany['website'] }}


<strong>Date Added</strong> 
    <p> {{ $newCompany['created_at'] }}</p>

@endcomponent
