<?php

namespace Tests\Localizations;

use Tests\TestCase;

final class FrTest extends TestCase
{
    public function testApp()
    {
        $this->setConfigLocale('fr');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Action');
        $response->assertSee('Actualiser la liste des routes');
        $response->assertSee('Api');
        $response->assertSee('Aucun résultat');
        $response->assertSee('Aucune donnée disponible');
        $response->assertSee('Chargement, veuillez patienter ...');
        $response->assertSee('Chemin');
        $response->assertSee('Chercher');
        $response->assertSee('de');
        $response->assertSee('Domaine');
        $response->assertSee('Effacer le cache des routes');
        $response->assertSee('Middlewares');
        $response->assertSee('Module');
        $response->assertSee('Méthodes');
        $response->assertSee('Nom');
        $response->assertSee('Obsolète');
        $response->assertSee('Ouvrir la page du projet sur GitHub');
        $response->assertSee('Priorité');
        $response->assertSee('Routes par page');
        $response->assertSee('Routes');
        $response->assertSee('Sans');
        $response->assertSee('Tout');
        $response->assertSee('Tout');
        $response->assertSee('Types de routes');
        $response->assertSee('Uniquement');
        $response->assertSee('Voir');
        $response->assertSee('Web');

        $response->assertSee('{0}-{1} sur {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }

    public function testPackage()
    {
        $this->setConfigLocale('en', 'fr');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Action');
        $response->assertSee('Actualiser la liste des routes');
        $response->assertSee('Api');
        $response->assertSee('Aucun résultat');
        $response->assertSee('Aucune donnée disponible');
        $response->assertSee('Chargement, veuillez patienter ...');
        $response->assertSee('Chemin');
        $response->assertSee('Chercher');
        $response->assertSee('de');
        $response->assertSee('Domaine');
        $response->assertSee('Effacer le cache des routes');
        $response->assertSee('Middlewares');
        $response->assertSee('Module');
        $response->assertSee('Méthodes');
        $response->assertSee('Nom');
        $response->assertSee('Obsolète');
        $response->assertSee('Ouvrir la page du projet sur GitHub');
        $response->assertSee('Priorité');
        $response->assertSee('Routes par page');
        $response->assertSee('Routes');
        $response->assertSee('Sans');
        $response->assertSee('Tout');
        $response->assertSee('Tout');
        $response->assertSee('Types de routes');
        $response->assertSee('Uniquement');
        $response->assertSee('Voir');
        $response->assertSee('Web');

        $response->assertSee('{0}-{1} sur {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }

    public function testIncorrect()
    {
        $this->setConfigLocale('fr', 'foo');

        $response = $this->get('/routes');

        $response->assertStatus(200);

        $response->assertSee('Action');
        $response->assertSee('Actualiser la liste des routes');
        $response->assertSee('Api');
        $response->assertSee('Aucun résultat');
        $response->assertSee('Aucune donnée disponible');
        $response->assertSee('Chargement, veuillez patienter ...');
        $response->assertSee('Chemin');
        $response->assertSee('Chercher');
        $response->assertSee('de');
        $response->assertSee('Domaine');
        $response->assertSee('Effacer le cache des routes');
        $response->assertSee('Middlewares');
        $response->assertSee('Module');
        $response->assertSee('Méthodes');
        $response->assertSee('Nom');
        $response->assertSee('Obsolète');
        $response->assertSee('Ouvrir la page du projet sur GitHub');
        $response->assertSee('Priorité');
        $response->assertSee('Routes par page');
        $response->assertSee('Routes');
        $response->assertSee('Sans');
        $response->assertSee('Tout');
        $response->assertSee('Tout');
        $response->assertSee('Types de routes');
        $response->assertSee('Uniquement');
        $response->assertSee('Voir');
        $response->assertSee('Web');

        $response->assertSee('{0}-{1} sur {2}');

        $response->assertDontSee('Foo Bar');
        $response->assertDontSee('Routes per page');
    }
}
