<?php

class Controler_Admin
{
	public function start()
	{
		$User=User::getInstance();
		if($User->check(10))
		{
			$SystemFinder = new masterSystem();
			$SystemManager = new masterManager();
			$Request= new Request();
			
			switch ($Request->getAsString('action'))
			{	
			
				case "ChanceUserPass":
				{
					if ($Request->getAsString("s_Pass") && $Request->getAsString("UserId") && strlen($Request->getAsString("s_Pass"))>5)
					{
						$UserManager= new UserManager();
						$UserManager->updateUserPass(md5($Request->getAsString("s_Pass")),$Request->getAsString("UserId"));
					}else
					{
						$UserFinder= new UserFinder();
						$UserCollection =$UserFinder->findAllUser();
						$View = Template::getInstance("tpl_AdminShowUser.php");
						$View->assign("ErrorString","Das Passwort wurde nicht geändert");
						$View->assign("UserCollection",$UserCollection);
						$View->render();
					}
				}
				case "ShowUserWorkOn":
				{
					$UserFinder= new UserFinder();
					$UserCollection =$UserFinder->findAllUser();
					$View = Template::getInstance("tpl_AdminShowUser.php");
					$View->assign("UserCollection",$UserCollection);
					$View->render();
				}break;	
			
				
				case "WordFilter"://***************************************************************************************************************************************
					$View = Template::getInstance("tpl_AdminBadWordTemplate.php");
					$View->assign("badWords",$SystemFinder->findBadWords());
					$View->render();
				break;	
				case "updateBadWords"://***********************************************************************************************************************************
					$SystemManager->updateBadWords($Request->getAsString("badWords"));
				break;	
				
				
				case "CreateNews"://**************************************************************************************************************************************
					$View = Template::getInstance("tpl_AdminCreateNews.php");
					$View->assign("Date",date("d:m:Y , h:i:s"));
					$View->render();
				break;	
				
				case "InsertNews"://***************************************************************************************************************************************
					$NewsManager= new NewsManager();
					if ($Request->getAsString('NewsText'))
					{
						$NewsManager->insertNews($Request->getAsString('NewsText'),$User->getID());
					}
					$View = Template::getInstance("tpl_UpdateTemplate.php");
					$View->assign("Message","der Newseintrag wurde erfolgreich eingetragen");
					$View->assign("Button","<a  href='index.php?section=admin&action=CreateNews'><img src='images/Back.png' title='zurück' /></a>");
					$View->render();
				break;	
				
				
				case "NewsWorkOn"://****************************************************************************************************************************************
				{
				$NewsManager= new NewsManager();
				
					if ($Request->getAsString('Delete') == "True")
					{
						$NewsManager->deleteById($Request->getAsInt('Id'));
						$View = Template::getInstance("tpl_AdminMessageWorkOn.php");
						$NewsFinder= new NewsFinder();
						$NewsCollection =$NewsFinder->findAll();
						$View->assign("NewsCollection",$NewsCollection);	
						$View->render();
						return true;

					}
					if($Request->getAsString('NewsContent') && $Request->getAsInt('Id'))
					{
						$NewsManager->updateNewsById($Request->getAsString('NewsContent'),$Request->getAsInt('Id'));
					}
					$View = Template::getInstance("tpl_AdminMessageWorkOn.php");
					$NewsFinder= new NewsFinder();
					$NewsCollection =$NewsFinder->findAll();
					$View->assign("NewsCollection",$NewsCollection);	
					$View->render();
				}break;	
				
				
				
				case "CreateTurnier":
					{
						// turnier template laden
						$View = Template::getInstance("tpl_AdminCreateNewTurnier.php");
						$View->render();
						
						
					}break;
				case "InsertTurnier":
					{			
						$Turnier = new Turnier(0,$Request->getAsString("TurnierName"),$Request->getAsString("TurnierAnmeldeSchluss"),$Request->getAsString("TurnierGameTyp"),$Request->getAsString("TurnierSpiel"),$Request->getAsString("TurnierSpielZeit"),$Request->getAsString("TurnierStart"),$Request->getAsString("TurnierModus"),$Request->getAsString("TurnierPlayerInMatch"),new SquadCollection(),new MatchCollection());
						$TurnierManager= new TurnierManager();
						if ($TurnierManager->InsertTurnier($Turnier))
						{
								$View= Template::getInstance("tpl_UpdateTemplate.php");
								$View->assign("Button","");
								$View->assign("Message","Das Turnier wurde erfolgreich angelegt");
								$View->render();
						}else 
						{
								$View= Template::getInstance("tpl_ErrorTemplate.php");
								$View->assign("From","");
								$View->assign("Message","Bei der erstellung des Turniers trat ein fehler auf");
								$View->render();
						}
						
					}break;
				
				
				
				case "CreateFoodGroup":
					{			
						$View= Template::getInstance("tpl_CateringCreateGroup.php");
						$FoodFinder= new CateringFinder();	
						$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups());
						$View->render();
					}break;
				case "insertFoodGroup":
				{	

					$GroupName= $Request->getAsString("FoodGroupName");
					$GroupDescription= $Request->getAsString("FoodGroupDescription");
					$CateringManager= new CateringManager();
					$View= Template::getInstance("tpl_CateringCreateGroup.php");
					$FoodFinder= new CateringFinder();	
					$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups());		
					if ($CateringManager->insertFoodGroup($GroupName,$GroupDescription))
					{
						$View->assign("Message","Die gruppe wurde erfolgreich eingetragen");
					}else
					{
						$View->assign("Message","Die gruppe wurde nicht eingetragen");
					}
					
					$View->render();
					
				}break;	
				
				case "deleteFoodGroup":
				{
					$View= Template::getInstance("tpl_CateringCreateGroup.php");
					$FoodFinder= new CateringFinder();	
					$CateringManager= new CateringManager();
					if ($CateringManager->deleteGroupById($Request->getAsString("FoodId")))
					{
						$View->assign("Message","Die gruppe wurde erfolgreich entfernt");
					}else
					{
						$View->assign("Message","Die gruppe wurde nicht entfernt");
					}
					$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups());
					$View->render();
				}break;
				
				case "CreateFood":
				{			
					$View= Template::getInstance("tpl_CateringInsertFood.php");
					$FoodFinder= new CateringFinder();	
					$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups(true));
					$View->render();
				}break;
					
				case "insertFood":
				{	
					$FoodName= $Request->getAsString("FoodName");
					$FoodDescription= $Request->getAsString("FoodDescription");
					$FoodSmall= $Request->getAsString("FoodPriceSmall");
					$FoodNormal= $Request->getAsString("FoodPriceNormal");
					$FoodLarge= $Request->getAsString("FoodPriceLarge");
					$FoodIncredents= $Request->getAsString("FoodIncredents");
					$FoodExtentionsable= $Request->getAsString("FoodExtentionsable");
					$FoodGroupId= $Request->getAsString("GroupId");
					$TempPrice="";
					
					$FoodSmall=str_replace(",",".",$FoodSmall);
					$FoodNormal=str_replace(",",".",$FoodNormal);
					$FoodLarge=str_replace(",",".",$FoodLarge);
					
					if($FoodSmall)
					{
						$TempPrice="klein:".$FoodSmall;
					}
					if($FoodNormal)
					{
						if($FoodSmall)
						{
							$TempPrice.=";";
						}
						$TempPrice.="Normal:".$FoodNormal;
					}
					if($FoodLarge)
					{
						if($FoodNormal)
						{
							$TempPrice.=";";
						}
						$TempPrice.="Groß:".$FoodLarge;
					}
					$CateringManager= new CateringManager();
					$View= Template::getInstance("tpl_CateringInsertFood.php");
					$FoodFinder= new CateringFinder();	
							
					if ($CateringManager->insertFood($FoodName,$FoodDescription,$TempPrice,$FoodIncredents,$FoodExtentionsable,$FoodGroupId))
					{
						$View->assign("Message","Das Objekt wurde erfolgreich eingetragen");
					}else
					{
						$View->assign("Message","Das Objekt wurde nicht eingetragen");
					}
					$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups(true));
					$View->render();
					
				}break;	
					
				case "DeleteFood":
				{
					$CateringManager= new CateringManager();
					$View= Template::getInstance("tpl_CateringInsertFood.php");
					$FoodFinder= new CateringFinder();	
					
					if ($CateringManager->deleteById($Request->getAsString("FoodId")))
					{
						$View->assign("Message","Das Objekt wurde erfolgreich eingetragen");
					}else
					{
						$View->assign("Message","Das Objekt wurde nicht eingetragen");
					}
					$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups(true));
					$View->render();
					
				}break;
				
					
				case "ShowFoodOrder": // bestellungen sichtn 
				{

					if ($Request->getAsString("Modus")=="WorkOn")
					{
						$FoodManager= new FoodOrderManager();
						$TempModus=$Request->getAsInt("cb_Modus");
						$TempArray=$Request->getAsArray("ia_ID");
						if (!empty($TempArray))
						{
							foreach($Request->getAsArray("ia_ID") as $Id)
							{
								$FoodManager->updateFoodOrder($Id,$TempModus,$User->getId());
							}
						}
					}
					
					
					
					$UserFinder = new UserFinder();
					$UserCollection =$UserFinder->findAllUser();
					$FoodOrderFinder= new FoodOrderFinder();

					switch($Request->getAsString("View"))
					{
						
						case "ShowOrder":
						{ // die ansicht zum bestellen 
							$FoodOrderArray=$FoodOrderFinder->findAllById($Request->getAsInt("i_Id"));
							$View= Template::getInstance("tpl_AdminCateringOrdnerNow.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","Bestellungsübersicht");
							$View->assign("View","ShowOrder");
						}break;
						
						
						case "Archiv":
						{
							$FoodOrderArray=$FoodOrderFinder->findAllArchiv();
							$View= Template::getInstance("tpl_CateringAdminShowAll.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","alle abgebrochenen Bestellungen");
							$View->assign("View","Archiv");
						}break;
						
						
						case "OrderNow":
						{ // die ansicht zum bestellen 
							$FoodOrderArray=$FoodOrderFinder->findAllPaid();
							$View= Template::getInstance("tpl_AdminCateringOrdnerNow.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","alle bezahlten Bestellungen");
							$View->assign("View","OrderNow");
						}break;
						
						
						case "Supply":
						{
							$FoodOrderArray=$FoodOrderFinder->findAllSupply();
							$View= Template::getInstance("tpl_CateringAdminShowAll.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","alle ausgelieferten Bestellungen");
							$View->assign("View","Supply");
						}break;
						
						case "Aborted":
						{
							$FoodOrderArray=$FoodOrderFinder->findAllAborted();
							$View= Template::getInstance("tpl_CateringAdminShowAll.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","alle abgebrochenen Bestellungen");
							$View->assign("View","Aborted");
						}break;
						
						case "Ordered":
						{
							$FoodOrderArray=$FoodOrderFinder->findAllOrdered();
							$View= Template::getInstance("tpl_CateringAdminShowAll.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","alle bestellte Bestellungen");
							$View->assign("View","Ordered");
						}break;
						case "NonePaid":
						{
							$FoodOrderArray=$FoodOrderFinder->findAllNonePaid();
							$View= Template::getInstance("tpl_CateringAdminShowAll.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","alle nicht bezahlte Bestellungen");
							$View->assign("View","NonePaid");
						}break;
						case "Paid":
						{
							$FoodOrderArray=$FoodOrderFinder->findAllPaid();
							$View= Template::getInstance("tpl_CateringAdminShowAll.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","bezahlte Bestellungen");
							$View->assign("View","Paid");
						}break;
						default:
							$FoodOrderArray=$FoodOrderFinder->findAllWhitoutArchiv();
							$View= Template::getInstance("tpl_CateringAdminShowAll.php");
							$View->assign("FoodArray",$FoodOrderArray);
							$View->assign("UserCollection",$UserCollection);
							$View->assign("Message","alle Bestellungen");
							$View->assign("View","All");
					}
					$View->render();
				}break;
				
				
				case "ShowWorkOn":
				{
					if($Request->getAsString("FoodId"))
					{
						$View= Template::getInstance("tpl_CateringElementWorkOn.php");
						$FoodFinder= new CateringFinder();
						$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups(true));
						$FoodElement=$FoodFinder->findById($Request->getAsString("FoodId"));
						$View->assign("FoodElement",$FoodElement);
						
						$TempPrice= explode(";",$FoodElement->getPrice());
						$TempSmall=explode(":",$TempPrice[0]);
						$TempMedium=explode(":",$TempPrice[1]);
						$TempLagre=explode(":",$TempPrice[2]);
						
						$View->assign("Small",$TempSmall[1]);
						$View->assign("Medium",$TempMedium[1]);
						$View->assign("Lagre",$TempLagre[1]);
						$View->render();
					}break;

				}
				
				case "WorkOnFood":
				{
					$FoodName= $Request->getAsString("FoodName");
					$FoodDescription= $Request->getAsString("FoodDescription");
					$FoodSmall= $Request->getAsString("FoodPriceSmall");
					$FoodNormal= $Request->getAsString("FoodPriceNormal");
					$FoodLarge= $Request->getAsString("FoodPriceLarge");
					$FoodId=$Request->getAsString("FoodID");
					$FoodGroupId= $Request->getAsString("GroupId");
					$TempPrice="";
					
					$FoodSmall=str_replace(",",".",$FoodSmall);
					$FoodNormal=str_replace(",",".",$FoodNormal);
					$FoodLarge=str_replace(",",".",$FoodLarge);
					
					if($FoodSmall)
					{
						$TempPrice="klein:".$FoodSmall;
					}
					if($FoodNormal)
					{
						if($FoodSmall)
						{
							$TempPrice.=";";
						}
						$TempPrice.="Normal:".$FoodNormal;
					}
					if($FoodLarge)
					{
						if($FoodNormal)
						{
							$TempPrice.=";";
						}
						$TempPrice.="Groß:".$FoodLarge;
					}
					$CateringManager= new CateringManager();
					$View= Template::getInstance("tpl_CateringInsertFood.php");
					$FoodFinder= new CateringFinder();	
					
					if ($CateringManager->updateFood($FoodId,$FoodName,$FoodDescription,$TempPrice,$FoodGroupId))
					{
						$View->assign("Message","Das Objekt wurde erfolgreich Bearbeitet");
					}else
					{
						$View->assign("Message","Das Objekt wurde nicht Bearbeitet");
					}
					$View->assign("FoodGroup",$FoodFinder->findAllFoodGroups(true));
					$View->render();
				}break;
					default:
						$View = Template::getInstance("tpl_AdminMainTemplate.php");
						$View->render();
			}
	
		}
	}
}





?>