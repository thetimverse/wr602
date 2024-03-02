describe('Formulaire d\'Inscription', () => {
    it('test 1 - inscription réussie', () => {
        cy.visit('http://127.0.0.1:8000/register');

        // Remplir les champs du formulaire d'inscription
        cy.get('#registration_form_email').type('cypress@gmail.com');
        cy.get('#registration_form_plainPassword').type('123456'); 
        cy.get('#registration_form_agreeTerms').check();
        // Soumettre le formulaire d'inscription
        cy.get('button[type="submit"]').click();

        // Vérifier que l'inscription a été réussie, peut-être par la présence d'un message de succès ou la redirection vers une page de connexion
        cy.contains('Please sign in').should('exist'); 
    });

    it('test 2 - inscription échouée', () => {
        cy.visit('http://127.0.0.1:8000/register');

        cy.get('#registration_form_email').type('tim.mockingjay09@gmail.com'); // Utiliser un email déjà enregistré pour provoquer une erreur
        cy.get('#registration_form_plainPassword').type('test');
        cy.get('#registration_form_agreeTerms').check();

        // Soumettre le formulaire d'inscription
        cy.get('button[type="submit"]').click();

        // Vérifier la présence d'un message d'erreur (ex: email déjà utilisé)
        cy.contains('There is already an account with this email').should('exist'); // Remplacer 'Email déjà utilisé' par le message d'erreur réel attendu
    });
});