<optgroup label="Jiaguwen " style="color:#000000; background-color:#ffff99">
<option>SELECT * FROM Jiaguwen                                           ;;;count=6186</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,10</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,500</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 1000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 2000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 3000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 4000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 5000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 6000,1000</option>
<option>SELECT * FROM Jiaguwen WHERE jink LIKE '%62548,%' ORDER BY jink</option>
<option>SELECT * FROM Jiaguwen WHERE jink LIKE '%' ORDER BY jink          ;;;count=6155 (everything not null)</option>
<option>SELECT * FROM Jiaguwen WHERE jink LIKE '%,' ORDER BY jink         ;;;count=5196 (one or more)  --(1) </option>

<option>SELECT * FROM Jiaguwen WHERE jink LIKE '_____,' ORDER BY jink     ;;;count= 351 (single) </option>
<option>SELECT * FROM Jiaguwen WHERE jink LIKE '_____,_%' ORDER BY jink   ;;;count=4837 (Two Or more) </option>
<option>SELECT * FROM Jiaguwen WHERE jink LIKE '_____,%' ORDER BY jink    ;;;count=5188 (one or more)   --(2) ??</option>

<option>SELECT * FROM Jiaguwen WHERE jink='' OR jink IS NULL              ;;;count= 990</option>
<option>SELECT * FROM Jiaguwen WHERE jink IS NULL                         ;;;count=  31</option>
<option>SELECT * FROM Jiaguwen WHERE jink = ''                            ;;;count= 959 </option>



<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink DESC</option>
<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink ASC</option>
<option>SELECT * FROM Jiaguwen WHERE jnm LIKE '%,%'</option>
<option>SELECT * FROM Jiaguwen WHERE jnm <>""</option>
<option>SELECT * FROM Jiaguwen WHERE jnm IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE jnm IS NOT NULL </option>
<option>SELECT * FROM Jiaguwen WHERE (jink='' OR jink IS NULL) and jnm=0 ;;;Unfinished. count= 990</option>
<option>SELECT * FROM Jiaguwen WHERE L IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE L!='4' AND xa!='x'</option>
<option>SELECT * FROM Jiaguwen WHERE  xa='x'</option>
<option>SELECT * FROM Jiaguwen WHERE jink='' AND L!='1' AND L!='5' AND xa!='x' </option>
<option>SELECT * FROM Jiaguwen WHERE L IS NOT NULL ORDER BY L</option>
<option>SELECT jid FROM Jiaguwen</option>
<option>SELECT jid, zid FROM Jiaguwen</option>
<option>SELECT jid,zid, freq  FROM Jiaguwen GROUP BY zid ORDER BY freq</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink=''</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink IS NULL</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink LIKE '_____,'</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink LIKE '_____,_____,%'</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen LIMIT 0,10</option>
<option>SELECT jid, pyn FROM Jiaguwen WHERE jink IS NULL or jink='' ;;;count= 31000 ;;; find root words</option>

<option>SELECT jnm, jid FROM Jiaguwen  WHERE jnm<>'0' AND jnm <>'-' AND jnm<>'' ORDER BY jnm  LIMIT 0,10000 ;;; for tree view</option>

<optgroup label="DISTINCT " style="color:#000000; background-color:#11ff99">
<option>SELECT DISTINCT jink FROM Jiaguwen WHERE jink LIKE '_____,'</option>
<option>SELECT DISTINCT jnm FROM Jiaguwen ORDER BY jnm</option>
</optgroup>



</optgroup>

<optgroup label="Bronze " style="color:#000000; background-color:#aabbcc">
<option>SELECT * FROM bronze0000shang  LIMIT 0,10</option>
<option>SELECT idx, jink, zids,pinyin FROM bronze0000shang WHERE jink like '%61660,%'</option>
</optgroup>




<optgroup label="Hieroglyphics " style="color:#000000; background-color:#ffff99">
<option>SELECT * FROM Hieroglyphics LIMIT 0,10</option>
<option>SELECT * FROM Hieroglyphics LIMIT 0,100000</option>
</optgroup>





<optgroup label="Mixed Jiaguwen and Hieroglyphics " style="color:#000000; background-color:#ffff99">
<option>SELECT 'Jiaguwen.jid', 'Hieroglyphics.hid' FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx != ''   LIMIT 0,100</option>
<option>SELECT 'Jiaguwen.jid' , 'Hieroglyphics.hid'  FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx <10   LIMIT 0,10</option>
<option>SELECT 'Jiaguwen.jid' jid, 'Hieroglyphics.hid' hid FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx <10   LIMIT 0,10</option>
</optgroup>


<optgroup label="PictureToday " style="color:#000000; background-color:#ffff99">
<option>SELECT *  FROM PictureToday    LIMIT 0,10</option>
<option>SELECT *  FROM PictureToday_jid2pic_    LIMIT 0,10</option>
</optgroup>


<optgroup label="Zid2pinyin  " style="color:#000000; background-color:#ffff99">
<option>SELECT *  FROM Zid2pinyin     LIMIT 0,10</option>
<option>SELECT jid, Jiaguwen.zid, Zid2pinyin.pinyins FROM Jiaguwen , Zid2pinyin where Jiaguwen.zid=Zid2pinyin.zid</option>
<option>SELECT Jiaguwen.idx, Jiaguwen.jid, Jiaguwen.zid, Jiaguwen.zid1, Jiaguwen.jink, Zid2pinyin.pinyins FROM Jiaguwen   LEFT JOIN Zid2pinyin ON Jiaguwen.zid=Zid2pinyin.zid</option>
<option>SELECT Jiaguwen.*, Zid2pinyin.pinyins FROM Jiaguwen LEFT JOIN Zid2pinyin  ON Jiaguwen.zid=Zid2pinyin.zid</option>

</optgroup>





<optgroup label="temp-transition-table " style="color:#000000; background-color:#ffff77">
<option>SELECT *  FROM ttt    LIMIT 0,10</option>
<option>SELECT DISTINCT src FROM ttt ORDER BY idx DESC LIMIT 10</option>
</optgroup>

<optgroup label="UPDATE SAMPLE (be carefule!!!)" style="color:#000000; background-color:#ff1212">
<option>UPDATE Jiaguwen SET jnm='xyz' WHERE jnm='abc'</option>
<option>UPDATE Jiaguwen SET hink='xyz' WHERE hink='abc'</option>
</optgroup>