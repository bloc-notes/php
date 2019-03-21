        <footer id="divPiedPage" class="sGris sBeigePolice sPiedPage">
            <nav class="sMenu sTurquoise sBordure8">
                <h2>Liens utiles</h2>
                <li class="sEspaceLien">
                    <a href="https://login.microsoftonline.com">Courriel</a>
                </li>
                <li class="sEspaceLien">
                    <a href="http://424w.cgodin.qc.ca/lmbrousseau/">Disponibilité</a>
                </li>
                <li class="sEspaceLien">
                    <a href="https://www.cgodin.qc.ca/">G.-G.</a>
                </li>
                <li class="sEspaceLien">
                    <a href="https://cgodin.omnivox.ca">Omnivox</a>
                </li>  
            </nav>
            <p class="sPolice12" style="border-left:15px solid transparent;">
                &copy; Marc-Antoine Lussier, Mohamed Hassan Guelleh, Philippe Doyon
            </p>
        </footer>
    </form>
    <form id="frmEtat" method="POST" action="<?php isset($_SESSION["actionFrmEtat"]) ? $_SESSION["actionFrmEtat"] : ""; ?>">
        <input id="hidEtat" name="hidEtat" type="hidden" />
        <input id='hidIdElement' name ='hidIdElement' type="hidden" />
    </form>
</body>
</html>