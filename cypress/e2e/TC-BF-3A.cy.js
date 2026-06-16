describe('TC-BF-3A: Admin mengakses dashboard dengan session aktif', () => {

    it('Admin berhasil login dan dapat mengakses dashboard', () => {

   
        cy.visit('http://127.0.0.1:8000/login')

        cy.get('input#email')
            .clear()
            .type('super@admin.com')

        cy.get('input#password')
            .clear()
            .type('admin123')

        cy.get('button[type="submit"]').click()

        cy.url().should('include', '/dashboard')

        cy.visit('http://127.0.0.1:8000/dashboard')

        cy.url().should('include', '/dashboard')

        cy.screenshot('TC-BF-3A -- Admin mengakses dashboard dengan session aktif')
    })

})
