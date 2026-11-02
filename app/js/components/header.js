function Header({ user, onLogout }) {
    return (
        <nav className="navbar navbar-dark bg-dark mb-4 shadow-sm px-4">
            <span className="navbar-brand">MapCo</span>
            <div className="d-flex align-items-center">
                {user && (
                    <>
                        <span className="text-white me-3">
                            Ahoj <strong>{user}</strong>
                        </span>
                        <button onClick={onLogout} className="btn btn-outline-danger btn-sm">
                            Odhlásit se
                        </button>
                    </>
                )}
            </div>
        </nav>
    );
}