<?php echo '<' . '?xml version="1.0" encoding="utf-8"?' . '>' . "\n" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title>BU Shout</title>
	<link rel="self" href="<?php echo base_url() ?>"/>
	<id><?php echo base_url() ?></id>
	<updated><?php echo date('Y-m-d\TH:i:sP', strtotime($shouts->row()->date)); ?></updated>
	<author>
		<name>BU Student Union</name>
		<uri>http://www.bustudentunion.com</uri>
	</author>

<?php foreach ($shouts->result() as $shout): ?>
	<entry>
		<id><?php echo base_url() ?>shout/detail/<?php echo $shout->id ?></id>
		<title><?php echo $shout->title ?></title>
		<content><?php echo $shout->body ?></content>
		<published><?php echo date('Y-m-d\TH:i:sP', strtotime($shout->date)) ?></published>
		<updated><?php echo date('Y-m-d\TH:i:sP', strtotime($shout->lastpost)) ?></updated>
	</entry>
<?php endforeach; ?>
	
</feed>