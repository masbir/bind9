acl {{ $dnsview->clients_label }} {
	@foreach($dnsview->ips as $ip)
	{{ $ip->ipstart }}/{{ $ip->range }};
    @endforeach 
};
view {{ $dnsview->view_label }}{
    match-clients { {{ $dnsview->clients_label }}; };
    allow-recursion { any; };

    @foreach($dnsview->domains as $domain) 
	zone "{{ $domain->domain }}" { type master; notify no; file "/etc/bind/null.zone.file"; };
    @endforeach 
};