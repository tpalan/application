<?php require_once('../qcubed.inc.php');

	// Setup the Feed, itself
	$objRss = new QRssFeed('Examples Site Projects', 'http://examples.qcu.be/', 'An Example RSS feed of the Qcubed Examples Site Projects');
	$objRss->Image = new QRssImage('http://www.qcu.be/sites/all/themes/qcubednew/images/QCubed.png');
	$objRss->PubDate = new \QCubed\QDateTime(\QCubed\QDateTime::NOW);
	
	// Iterate through all the projects, and setup a QRssItem per project
	// Limit it to the "10 most recently started projects"
	foreach ($objProjects = Project::LoadAll(\QCubed\Query\QQ::Clause(\QCubed\Query\QQ::OrderBy(QQN::Project()->StartDate, false), \QCubed\Query\QQ::LimitInfo(10))) as $objProject) {
		$objItem = new QRssItem($objProject->Name,
			'http://examples.qcu.be/examples/communication/rss.php/' . $objProject->Id,
			$objProject->Description);
	
		$objItem->Author = $objProject->ManagerPerson->FirstName . ' ' . $objProject->ManagerPerson->LastName;
		$objItem->PubDate = $objProject->StartDate;
		$objItem->Guid = $objItem->Link;
		$objItem->GuidPermaLink = true;
		$objItem->AddCategory(new QRssCategory('Some Project Category 1'));
		$objItem->AddCategory(new QRssCategory('Some Project Category 2'));

		$objRss->AddItem($objItem);
	}

	// Output/Run the feed
	// Note that the Run method will reset the output buffer and setup the Headers to output XML,
	// so any HTML or Text outputted until now will be lost.  If for whatever reason you just
	// want the XML, you can call $objRss->GetXml(), which will return the XML string.
	// Also, if you need to change the encoding of the XML, you can do so in \QCubed\Project\Application::encodingType().
	$objRss->Run();
?>