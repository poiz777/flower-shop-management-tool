<?php
	
	
	namespace App\Helpers\General;
	
	
	use Doctrine\ORM\EntityManagerInterface;
	
	class PaymentBroker {
		
		/**
		 * @var EntityManagerInterface
		 */
		private $eMan;
		/**
		 * PaymentBroker constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface $eMan
		 */
		public function __construct(EntityManagerInterface $eMan) {
			$this->eMan = $eMan;
		}
		
		/**
		 * @param $saleDate
		 * @param $salePaymentMethod
		 * @param $department
		 *
		 *
		 * <code>
		 *     $qb = $em->createQueryBuilder()
		 *         ->select('u')
		 *         ->from('User', 'u')
		 *         ->where('u.username LIKE ?')
		 *         ->andWhere('u.is_active = 1');
		 * </code>
		 */
		private function getPaymentQuery($saleDate, $salePaymentMethod, $department){
			$qb             = $this->eMan->createQueryBuilder();
			$whereCondition = $qb->expr()->orX();
			# 'SUM(vkf.verkaufbetrag) AS saleAmount', 'COUNT(vkf.verkaufid) AS saleID'
			$qb ->select('vkf')
					->from('verkauf', 'vkf')
					->where($whereCondition)
					->andWhere($whereCondition)
					->andWhere();
			
			$sqlGeneric =<<<SQL

SELECT 	SUM(verkaufbetrag),
				COUNT(verkaufid) FROM verkauf
				WHERE verkaufdatum 					= '$saleDate'
				AND verkaufzahlungsmittel 	= $salePaymentMethod
				AND verkaufmitarbeiter 			= $department
SQL;
			$sqlGeneric2 =<<<SQL
SELECT 	SUM(verkaufbetrag),
				COUNT(verkaufid) FROM verkauf
				WHERE verkaufdatum 					= '$datum1'
				AND verkaufzahlungsmittel 	= 1
				AND verkaufmitarbeiter 			= $mitarbeiterin
SQL;

			
		/*
			$query_bar_mg = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 1 AND verkaufmitarbeiter = $mitarbeiterin";
			$bar_mg = mysql_query($query_bar_mg, $blumen) or die(mysql_error());
			$row_bar_mg = mysql_fetch_assoc($bar_mg);
			$bar_mg = $row_bar_mg['SUM(verkaufbetrag)'];
			if ($bar_mg == "") $bar_mg = 0;
			// Bar Hirschengraben
			$query_bar_hg = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 10 AND verkaufmitarbeiter = $mitarbeiterin";
			$bar_hg = mysql_query($query_bar_hg, $blumen) or die(mysql_error());
			$row_bar_hg = mysql_fetch_assoc($bar_hg);
			$bar_hg = $row_bar_hg['SUM(verkaufbetrag)'];
			// Postcard
			$query_pc = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 3 AND verkaufmitarbeiter = $mitarbeiterin";
			$pc = mysql_query($query_pc, $blumen) or die(mysql_error());
			$row_pc = mysql_fetch_assoc($pc);
			$pc = $row_pc['SUM(verkaufbetrag)'];
			// ec
			$query_ec = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 2 AND verkaufmitarbeiter = $mitarbeiterin";
			$ec = mysql_query($query_ec, $blumen) or die(mysql_error());
			$row_ec = mysql_fetch_assoc($ec);
			$ec = $row_ec['SUM(verkaufbetrag)'];
			// MasterCard
			$query_mc = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 4 AND verkaufmitarbeiter = $mitarbeiterin";
			$mc = mysql_query($query_mc, $blumen) or die(mysql_error());
			$row_mc = mysql_fetch_assoc($mc);
			$mc = $row_mc['SUM(verkaufbetrag)'];
			// VISA
			$query_vi = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 5 AND verkaufmitarbeiter = $mitarbeiterin";
			$vi = mysql_query($query_vi, $blumen) or die(mysql_error());
			$row_vi = mysql_fetch_assoc($vi);
			$vi = $row_vi['SUM(verkaufbetrag)'];
			// VPay
			$query_vp = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 13 AND verkaufmitarbeiter = $mitarbeiterin";
			$vp = mysql_query($query_vp, $blumen) or die(mysql_error());
			$row_vp = mysql_fetch_assoc($vp);
			$vp = $row_vp['SUM(verkaufbetrag)'];
			// Amex
			$query_am = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 6 AND verkaufmitarbeiter = $mitarbeiterin";
			$am = mysql_query($query_am, $blumen) or die(mysql_error());
			$row_am = mysql_fetch_assoc($am);
			$am = $row_am['SUM(verkaufbetrag)'];
			// BernCity
			$query_bc = "SELECT SUM(verkaufbetrag), COUNT(verkaufid) FROM verkauf where verkaufdatum = '$datum1' AND verkaufzahlungsmittel = 8 AND verkaufmitarbeiter = $mitarbeiterin";
			$bc = mysql_query($query_bc, $blumen) or die(mysql_error());
			$row_bc = mysql_fetch_assoc($bc);
			$bc = $row_bc['SUM(verkaufbetrag)'];
			*/
		}
	}