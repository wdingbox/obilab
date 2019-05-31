

<optgroup label="Compare Table/View Jiaguwen " style="color:#000000; background-color:#ffff33">
<option>CREATE OR REPLACE VIEW view_1 AS SELECT * FROM Jiaguwen WHERE jink LIKE '%,' ORDER BY jink         ;;;count=5196 (one or more)  --(1) </option>
<option>CREATE OR REPLACE VIEW view_2 AS SELECT * FROM Jiaguwen WHERE jink LIKE '_____,%' ORDER BY jink    ;;;count=5188 (one or more)   --(2) ??</option>
<option>SELECT view_1.*  FROM view_1 LEFT JOIN view_2 ON view_1.idx=view_2.idx WHERE view_2.idx IS NULL</option>
<option>SELECT * FROM view_1 WHERE view_1.idx NOT IN(SELECT view_2.idx FROM view_2 WHERE view_1.idx=view_2.idx) </option>
<option>SELECT * FROM view_2 WHERE view_2.idx NOT IN(SELECT view_2.idx FROM view_2 WHERE view_1.idx=view_2.idx) </option>
</optgroup>




<optgroup label="VIEW (../oopy/create_view.py) " style="color:#000000; background-color:#ffff33">
<option> CREATE OR REPLACE VIEW view_Jiaguwen_Roots AS SELECT * FROM Jiaguwen WHERE jink is NULL OR jink='' ;;; root</option>
<option>SELECT *  FROM view_Jiaguwen_Roots ;;; root tot=990   </option>
<option> </option>
<option>CREATE OR REPLACE VIEW view_Jiaguwen_Polymorphy AS SELECT * FROM Jiaguwen WHERE jink LIKE '_____,' ORDER BY jink ;;; similarities </option>
<option>SELECT *  FROM view_Jiaguwen_Polymorphy  ORDER BY jink ;;; count=351 </option>
<option>SELECT DISTINCT jink FROM view_Jiaguwen_Polymorphy WHERE jink LIKE '_____%' ORDER BY jink ;;;count=124 </option>

<option> </option>
<option>CREATE OR REPLACE VIEW view_Jiaguwen_Composite AS SELECT * FROM Jiaguwen WHERE jink LIKE '_____,_%'    ;;; Composite words </option>
<option>SELECT *  FROM view_Jiaguwen_Composite  ORDER BY jink ;;; count=4837 </option>


</optgroup>



<optgroup label="../oopy/mdb/Jiaguwen_Analyser.py" style="color:#000000; background-color:#aaff33">

<option>SELECT * FROM vtbl_lead_and_members</option>
<option>SELECT vtbl_lead_and_members.jid FROM vtbl_lead_and_members</option>
<option>SELECT * FROM vtbl_component_and_children ;;; component(root, element), children(leaf, element)</option>

<option></option>
<option>SELECT vtbl_lead_and_members.jid, vtbl_lead_and_members.jink, vtbl_component_and_children.jink jink2 FROM vtbl_lead_and_members FULL JOIN vtbl_component_and_children ON  vtbl_component_and_children.jid= vtbl_lead_and_members.jid</option>
<option></option>
<option>SELECT vtbl_lead_and_members.jid, vtbl_lead_and_members.jink, vtbl_component_and_children.jink       FROM vtbl_lead_and_members FULL JOIN vtbl_component_and_children ON  vtbl_component_and_children.jid= vtbl_lead_and_members.jid</option>

<option>;inner join</option>
<option>SELECT vtbl_lead_and_members.jid, vtbl_lead_and_members.jink, vtbl_component_and_children.jink AS jink2 FROM vtbl_lead_and_members , vtbl_component_and_children WHERE  vtbl_component_and_children.jid = vtbl_lead_and_members.jid ORDER BY vtbl_lead_and_members.jid</option>



<option>;;;union root, lead, components   (1623);;;</option>
<option>
 SELECT jid, jink  FROM view_Jiaguwen_Roots 
 UNION 
 SELECT vtbl_lead_and_members.jid , vtbl_lead_and_members.jink FROM vtbl_lead_and_members
 UNION 
 SELECT vtbl_component_and_children.jid,vtbl_component_and_children.jink FROM vtbl_component_and_children  ORDER BY jid
</option>
<option>;;;create view union root, lead, components   (1623);;;</option>
<option>
CREATE OR REPLACE VIEW view_union_root_lead_component AS 
 SELECT jid, jink  FROM view_Jiaguwen_Roots 
 UNION 
 SELECT vtbl_lead_and_members.jid , vtbl_lead_and_members.jink FROM vtbl_lead_and_members
 UNION 
 SELECT vtbl_component_and_children.jid,vtbl_component_and_children.jink FROM vtbl_component_and_children  ORDER BY jid GROUP jid
</option>
<option>
 SELECT * FROM view_union_root_lead_component  GROUP BY jid
</option>
<option>
 SELECT * FROM view_Jiaguwen_union_root_lead_component ORDER BY jnm</option>
<option></option>

<option>;crush</option>
<option>SELECT vtbl_lead_and_members.jid, vtbl_lead_and_members.jink, vtbl_component_and_children.jink AS jink2 FROM vtbl_lead_and_members , vtbl_component_and_children WHERE  vtbl_component_and_children.jid <> vtbl_lead_and_members.jid</option>
<option></option>
<option></option>
<option></option>
<option>UPDATE Jiaguwen jj, Zid2pinyin zz  SET jj.pyn=zz.pinyins  WHERE jj.zid1 = zz.zid </option>
</optgroup>


