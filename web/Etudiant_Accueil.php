<!DOCTYPE html>
<html>
	<head>
		<title>Accueil Etudiant</title>

	</head>
	<body>
			<h4> Vous êtes Connecté en tant qu'étudiant </h4>
			<button>Se déconnecter</button>
			<form method="post" action =({app.url_generator.generate('POST_add')})>
				<input type="text" name="todo" value="Rechercher"/>
				<button>Valid</button>
			</form>

	</body>
</html>

