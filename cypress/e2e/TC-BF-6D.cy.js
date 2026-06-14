describe('TC-BF-6D', () => {

    it('User memasukkan qty non integer', () => {

        cy.visit('http://127.0.0.1:8000/katalog-produk')

        cy.get('form')
            .first()
            .within(() => {

                cy.get('input[name="qty"]')
                    .clear()
                    .type('dua', { force: true })

                cy.get('input[name="qty"]')
                    .should('not.have.value', 'dua')
            })

    })

})