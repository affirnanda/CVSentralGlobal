describe('TC-BF-6C', () => {

    it('User memasukkan jumlah 0', () => {

        cy.visit('http://127.0.0.1:8000/katalog-produk')

        cy.get('form')
            .first()
            .within(() => {

                cy.get('input[name="qty"]')
                    .clear()
                    .type('0')

                cy.get('button[type="submit"]')
                    .click()
            })

        // expected result sesuai test case
        cy.contains('Silahkan isi jumlah produk yang ingin dipesan')
    })

})