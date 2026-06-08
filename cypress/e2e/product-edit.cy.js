describe('TC-BF-6Q Edit Product', () => {

    it('Admin mengedit produk dengan data yang benar', () => {

        cy.visit('http://127.0.0.1:8000/login')

        cy.get('input[name="email"]')
            .type('super@admin.com')

        cy.get('input[name="password"]')
            .type('admin123')

        cy.get('button[type="submit"]')
            .click()

        cy.visit('http://127.0.0.1:8000/admin/products')

        cy.contains('Edit')
            .first()
            .click()

        cy.get('input[name="name"]')
            .clear()
            .type('Laptop Testing Cypress')

        cy.get('textarea[name="description"]')
            .clear()
            .type('Produk berhasil diedit menggunakan Cypress')

        cy.get('input[name="price"]')
            .clear()
            .type('8000000')

        cy.get('input[name="rental_price"]')
            .clear()
            .type('1750000')

        cy.get('input[name="stock"]')
            .clear()
            .type('15')

        cy.get('button[type="submit"]')
            .click()

        cy.url().should('include', '/admin/products')
    })

})