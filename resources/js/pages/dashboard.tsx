import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={[{ title: 'Dashboard', href: '/dashboard' }]}>
            <Head title="Dashboard" />
            <div className="flex flex-col gap-5 p-8">
                <h1 className="text-3xl font-bold">Welkom bij Game Backlog</h1>
                <p>Bewaar de games die je nog wilt spelen.</p>
                <Link href="/games" className="w-fit rounded-lg bg-blue-600 px-5 py-3 text-white">Open mijn games</Link>
            </div>
        </AppLayout>
    );
}
